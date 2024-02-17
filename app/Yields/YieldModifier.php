<?php

namespace App\Yields;

use App\AbstractType;
use App\Enums\YieldType;
use App\GameConcept;
use App\Models\Building;
use App\Models\Citizen;
use App\Models\Hex;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class YieldModifier
{
    public function __construct(
        public GameConcept|Model $givenBy,
        public YieldType $type,
        public float     $amount = 0,
        public float     $percent = 0
    )
    {
    }

    /**
     * Combine YieldTypes (amounts and percents) into single amounts, forgetting what gave them originally
     * @param Collection<int, YieldModifier|YieldModifiersFor> $modifiers
     * @return Collection<int, YieldModifier|YieldModifiersFor>
     */
    public static function combineYieldTypes(Collection $modifiers, GameConcept|Model $givenBy): Collection
    {
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
            $forModifiers[] = $modifier;
        }

        /** @var Collection<string, YieldModifier>|YieldModifier[] $modifierByYieldType */
        $modifierByYieldType = [];
        foreach ($regularModifiers as $modifier) {
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
                $modifierByYieldType[$yieldType] = new YieldModifier($givenBy, YieldType::from($yieldType), $amount);
            } else {
                unset($modifierByYieldType[$yieldType]);
            }
        }

        return collect($modifierByYieldType)->sortKeys()->values()->merge($forModifiers);
    }

    /**
     * Given a list of YieldModifier & YieldModifiersFor objects,
     * returns YieldModifiers that apply for the given GameConcept or Model
     *
     * @param Collection<int, YieldModifier|YieldModifiersFor> $modifiers
     * @param GameConcept|Model|Collection<GameConcept|Model> $for
     * @param bool $combine Should Modifiers be combined, forgetting what gave them originally
     * @return Collection<int, YieldModifier>
     * @throws \Exception
     */
    public static function getValidModifiersFor(Collection $modifiers, GameConcept|Model|Collection $for, bool $combine = false): Collection
    {
        // Expand $for
        $fors = static::expandFors($for);

        $validModifiers = collect();

        foreach ($modifiers as $modifier) {
            // Regular YieldModifiers
            if ($modifier instanceof YieldModifier) {
                // Include if no $fors given, or the YieldType is for one of the given $fors
                if ($fors->isEmpty() || $modifier->type->isFor(...$fors)) {
                    $validModifiers->push($modifier);
                }
                continue;
            }

            // YieldModifiersFor are more complex

            // If no $fors given, the $modifier->for "was given"
            $modifierForWasGiven = $fors->isEmpty();

            if (!$modifierForWasGiven) {
                foreach ($modifier->for as $modifierFor) {
                    if ($modifierFor->is(...$fors)) {
                        $modifierForWasGiven = true;
                        break;
                    }
                }
            }

            if ($modifierForWasGiven) {
                foreach ($modifier->modifiers as $subModifier) {
                    // Include if no $fors given, or the YieldType is for one of the given $fors
                    if ($fors->isEmpty() || $subModifier->type->isFor(...$fors)) {
                        $validModifiers->push($subModifier);
                    }
                }
            }
        }

        return $combine
            ? static::combineYieldTypes($validModifiers, $for)
            : $validModifiers->sort(fn(YieldModifier $a, YieldModifier $b) => $a->type->value > $b->type->value);
    }

    /**
     * @param Collection<GameConcept|Model>|GameConcept|Model|null $for
     * @return Collection
     */
    public static function expandFors(Collection|GameConcept|Model|null $for): Collection
    {
        if (!$for) {
            return collect();
        }

        if (!$for instanceof Collection) {
            $for = [$for];
        }

        $expandedFors = [];
        foreach ($for as $forItem) {
            $expandedFors[] = $forItem;

            if ($forItem === null) {
                continue;
            }

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
                $forsToExpand = collect([
                    $forItem->domain,
                    $forItem->surface,
                    $forItem->feature,
                    $forItem->resource,
                    $forItem->improvement,
                ])->filter()
                    ->merge($forItem->buildings);

                foreach (static::expandFors($forsToExpand) as $expandedFor) {
                    $expandedFors[] = $expandedFor;
                }
                continue;
            }

            if ($forItem instanceof Unit) {
                $forsToExpand = collect([
                    $forItem->unitDesign->platform,
                    $forItem->unitDesign->equipment,
                    $forItem->unitDesign->armor,
                    $forItem->hex,
                ])->filter();

                foreach (static::expandFors($forsToExpand) as $expandedFor) {
                    $expandedFors[] = $expandedFor;
                }
                continue;
            }

            throw new \Exception(
                'Invalid forItem ' . (is_object($forItem) ? get_class($forItem) : gettype($forItem))
            );
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
