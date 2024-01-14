<?php

namespace App\Culture\Traits;

use App\Enums\Feature;
use App\Enums\Surface;
use App\Enums\YieldType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Bedouin extends CultureTrait
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
                    new YieldModifier(YieldType::Gold, 1),
                    new YieldModifier(YieldType::Production, 1),
                ]),
                Feature::Oasis
            ),
            new YieldModifiersFor(
                collect([new YieldModifier(YieldType::Damage, percent: -20)]),
                Surface::Desert
            ),
            new YieldModifiersFor(
                collect([new YieldModifier(YieldType::Movement, 1)]),
                Feature::Dunes
            ),
        ]);
    }
}
