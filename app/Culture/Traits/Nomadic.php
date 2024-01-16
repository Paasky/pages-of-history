<?php

namespace App\Culture\Traits;

use App\Enums\Feature;
use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Nomadic extends CultureTrait
{
    /**
     * @return Collection<int, YieldModifiersFor>
     */
    public function yieldModifiersFors(): Collection
    {
        return collect([
            new YieldModifiersFor(
                collect([new YieldModifier(YieldType::Food, 1)]),
                ImprovementCategory::Pastures
            ),
            new YieldModifiersFor(
                collect([
                    new YieldModifier(YieldType::Food, 1),
                    new YieldModifier(YieldType::Production, 1),
                ]),
                Feature::Shrubs
            ),
        ]);
    }
}
