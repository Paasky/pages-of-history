<?php

namespace App\Culture\Traits;

use App\Enums\Feature;
use App\Enums\YieldType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Tropical extends CultureTrait
{
    /**
     * @return Collection<int, YieldModifiersFor>
     */
    public function yieldModifierFors(): Collection
    {
        return collect([
            new YieldModifiersFor(
                collect([
                    new YieldModifier(YieldType::Food, 1),
                    new YieldModifier(YieldType::Health, 1),
                    new YieldModifier(YieldType::Damage, percent: -10),
                    new YieldModifier(YieldType::Movement, 1),
                ]),
                Feature::Jungle
            ),
        ]);
    }
}
