<?php

namespace App\Yields;

use App\Enums\YieldType;
use App\GameConcept;
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

    /**
     * @param Collection<int, YieldModifier|YieldModifiersFor> $modifiers
     * @param null|Collection<int, GameConcept> $for Pass in collect([null]) to ignore all YieldModifiersFors
     * @return Collection<int, YieldModifier|YieldModifiersFor>
     */
    public static function mergeModifiers(Collection $modifiers, Collection $for = null): Collection
    {
        // First separate the two types
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
        $modifierByYieldType = collect();
        foreach ($regularModifiers as $modifier) {
            $yieldTypeSlug = $modifier->type->slug();
            if (!isset($modifierByYieldType[$yieldTypeSlug])) {
                $modifierByYieldType[$yieldTypeSlug] = $modifier;
                continue;
            }

            $modifierByYieldType[$yieldTypeSlug]->amount += $modifier->amount;
            $modifierByYieldType[$yieldTypeSlug]->percent += $modifier->percent;
        }

        foreach ($modifierByYieldType as $yieldTypeSlug => $modifier) {
            if ($modifier->amount && $modifier->percent) {
                $modifierByYieldType[$yieldTypeSlug] = new YieldModifier(
                    $modifier->type,
                    round($modifier->amount * ((100 + $modifier->percent) / 100))
                );
            }
        }

        return $modifierByYieldType->sortKeys()->values()->merge($forModifiers);
    }
}
