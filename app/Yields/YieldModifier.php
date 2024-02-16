<?php

namespace App\Yields;

use App\AbstractType;
use App\Enums\YieldType;
use App\GameConcept;
use App\Models\Building;
use App\Models\Citizen;
use App\Models\Hex;
use Illuminate\Support\Collection;

class YieldModifier
{
    public function __construct(
        public YieldType $type,
        public float     $amount = 0,
        public float     $percent = 0
    )
    {
    }

    /**
     * @param Collection<int, YieldModifier|YieldModifiersFor> $modifiers
     * @param Collection|array|GameConcept|Building|Citizen|Hex|null $for Pass in collect([null]) to ignore all YieldModifiersFors
     * @return Collection<int, YieldModifier|YieldModifiersFor>
     */
    public static function mergeModifiers(
        Collection                                        $modifiers,
        Collection|array|GameConcept|Building|Citizen|Hex $for = null
    ): Collection
    {
        // Expand $for
        $for = static::expandFors($for);

        // Separate the two types of modifiers
        $regularModifiers = [];
        $forModifiers = [];
        /** @var YieldModifier|YieldModifiersFor $modifier */
        foreach ($modifiers as $modifier) {
            // Regular YieldModifiers are a simple list
            if ($modifier instanceof YieldModifier) {
                $regularModifiers[] = $modifier;
                continue;
            }

            // YieldModifiersFor are more complex

            // Nothing given as "for", so let them pass as-is
            if (!$for || $for->isEmpty()) {
                $forModifiers[] = $modifier;
                continue;
            }

            $isFor = false;
            foreach ($modifier->for as $modifierFor) {
                if ($modifierFor->is(...$for)) {
                    $isFor = true;
                    break;
                }
            }

            if ($isFor) {
                foreach ($modifier->modifiers as $subModifier) {
                    $regularModifiers[] = $subModifier;
                }
            }
        }

        /** @var Collection<string, YieldModifier>|YieldModifier[] $modifierByYieldType */
        $modifierByYieldType = [];
        foreach ($regularModifiers as $modifier) {
            if ($for?->isNotEmpty() && !$modifier->type->isFor(...$for)) {
                continue;
            }
            $yieldType = $modifier->type->value;
            if (!isset($modifierByYieldType[$yieldType])) {
                $modifierByYieldType[$yieldType] = [
                    '+' => max($modifier->amount, 0),
                    '-' => min($modifier->amount, 0),
                    '%' => $modifier->percent,
                ];
                continue;
            }

            $modifierByYieldType[$yieldType]['+'] += max($modifier->amount, 0);
            $modifierByYieldType[$yieldType]['-'] += min($modifier->amount, 0);
            $modifierByYieldType[$yieldType]['%'] += $modifier->percent;
        }

        foreach ($modifierByYieldType as $yieldType => $modifier) {
            $positive = $modifier['+'];
            $negative = $modifier['-'];
            $percent = $modifier['%'];

            if ($percent && $positive) {
                $positive += $positive * $percent / 100;
            }
            if ($percent && !$positive) {
                $negative += abs($negative) * $percent / 100;
            }
            $amount = round($positive + $negative, 2);

            if ($amount) {
                $modifierByYieldType[$yieldType] = new YieldModifier(YieldType::from($yieldType), $amount);
            }
        }

        return collect($modifierByYieldType)->sortKeys()->values()->merge($forModifiers);
    }

    /**
     * @param Collection|array|GameConcept|Building|Citizen|Hex|null $for
     * @return Collection
     */
    public static function expandFors(Collection|array|GameConcept|Building|Citizen|Hex $for = null): Collection
    {
        if (!$for) {
            return collect();
        }

        if (!$for instanceof Collection && !is_array($for)) {
            $for = [$for];
        }

        $expandedFors = [];
        foreach ($for as $forItem) {
            $expandedFors[] = $forItem;

            if ($forItem instanceof AbstractType) {
                $expandedFors[] = $forItem->category();
                continue;
            }

            if ($forItem instanceof GameConcept) {
                foreach ($forItem->items() as $item) {
                    $expandedFors[] = $item;
                }
                if (method_exists($forItem, 'class')) {
                    $expandedFors[] = $forItem->class();
                }
                continue;
            }

            if ($forItem instanceof Building) {
                foreach (static::expandFors(collect([$forItem->type])) as $typeFor) {
                    $expandedFors[] = $typeFor;
                }
                continue;
            }

            if ($forItem instanceof Citizen) {
                foreach (static::expandFors(collect([$forItem->workplace])) as $typeFor) {
                    $expandedFors[] = $typeFor;
                }
                continue;
            }

            if ($forItem instanceof Hex) {
                $forsToExpand = collect(
                    [$forItem->domain, $forItem->surface, $forItem->feature, $forItem->resource, $forItem->improvement]
                )
                    ->filter()
                    ->merge($forItem->buildings);
                foreach (static::expandFors($forsToExpand) as $expandedFor) {
                    $expandedFors[] = $expandedFor;
                }
            }
        }
        return collect($expandedFors);
    }

    public function color(): string
    {
        return ($this->amount ?: $this->percent) < 0 ? 'red' : 'green';
    }

    public function effect(): string
    {
        return implode([
            $this->percent && $this->percent > 0 ? '+' : '',
            $this->amount ?: $this->percent,
            $this->percent ? '%' : '',
        ]);
    }
}
