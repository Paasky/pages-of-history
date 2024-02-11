<?php

namespace App\Yields;

use App\Enums\YieldType;
use Illuminate\Support\Collection;

class YieldModifier
{
    public string $effect;
    public string $color;

    public function __construct(
        public YieldType $type,
        public float     $amount = 0,
        public float     $percent = 0
    )
    {
        $this->color = ($amount ?: $percent) < 0 ? 'red' : 'green';
        $this->effect = implode([
            $percent && $this->percent > 0 ? '+' : '',
            $amount ?: $percent,
            $this->percent ? '%' : '',
        ]);
    }

    /**
     * @param Collection<int, YieldModifier|YieldModifiersFor> $modifiers
     * @return Collection<int, YieldModifier|YieldModifiersFor>
     */
    public static function mergeModifiers(Collection $modifiers): Collection
    {
        /** @var YieldModifier[] $modifierByYieldType */
        $modifierByYieldType = [];
        $modifierFors = [];

        foreach ($modifiers as $modifier) {
            if ($modifier instanceof YieldModifier) {
                $slug = $modifier->type->slug();
                if (!isset($modifierByYieldType[$slug])) {
                    $modifierByYieldType[$slug] = $modifier;
                    continue;
                }

                $modifierByYieldType[$slug] = new YieldModifier(
                    $modifier->type,
                    $modifierByYieldType[$slug]->amount + $modifier->amount,
                    $modifierByYieldType[$slug]->percent + $modifier->percent
                );
                continue;
            }

            $modifierFors[] = $modifier;
        }

        foreach ($modifierByYieldType as $slug => $modifier) {
            if ($modifier->amount && $modifier->percent) {
                $modifierByYieldType[$slug] = new YieldModifier(
                    $modifier->type,
                    round($modifier->amount * ((100 + $modifier->percent) / 100))
                );
            }
        }

        ksort($modifierByYieldType);

        return collect($modifierByYieldType)->merge($modifierFors);
    }
}
