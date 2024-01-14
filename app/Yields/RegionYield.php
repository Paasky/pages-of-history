<?php

namespace App\Yields;

use App\Enums\YieldType;
use App\Models\Region;

class RegionYield
{
    protected float $baseYield = 0.0;
    protected float $modifier = 0.0;
    protected float $use = 0.0;
    protected float $desire = 0.0;

    public function __construct(protected Region $region, protected YieldType $yieldType)
    {
        $baseGain = $this->region->citizens;
        $modifiers = 0.25;
        $gain = $baseGain + $baseGain * $modifiers;
        $need = 1;
        $perTurn = $gain - $need;

        $happyEffectPerExcess = 0.01;
        $happyEffectPerDeficit = 0.05;
        $happyEffectMax = 0.1;
        $happyEffectMin = -1;

        $happyEffect = $perTurn >= 0
            ? min($perTurn * $happyEffectPerExcess, $happyEffectMax)
            : max($perTurn * $happyEffectPerDeficit, $happyEffectMin);

        $yieldEffectPerExcess = 0.01;
        $yieldEffectPerDeficit = 0.05;
        $yieldEffectMax = 0.1;
        $yieldEffectMin = -1;

        $yieldEffect = $perTurn >= 0
            ? min($perTurn * $yieldEffectPerExcess, $yieldEffectMax)
            : max($perTurn * $yieldEffectPerDeficit, $yieldEffectMin);
    }
}
