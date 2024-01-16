<?php

namespace App\Culture\Traits;

use App\Enums\Feature;
use App\Enums\Surface;
use App\Enums\YieldType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Arctic extends CultureTrait
{
    /**
     * @return Collection<int, YieldModifiersFor>
     */
    public function yieldModifiersFors(): Collection
    {
        return collect([
            new YieldModifiersFor(
                collect([new YieldModifier(YieldType::Production, 1)]),
                Surface::Tundra
            ),
            new YieldModifiersFor(
                collect([new YieldModifier(YieldType::Food, 1)]),
                Feature::PineForest
            ),
            new YieldModifiersFor(
                collect([new YieldModifier(YieldType::Damage, percent: -20)]),
                Surface::Snow
            ),
            new YieldModifiersFor(
                collect([new YieldModifier(YieldType::Movement, 1)]),
                Feature::Snowdrifts
            ),
        ]);
    }
}
