<?php

namespace App\Culture\Traits;

use App\Enums\Feature;
use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Seafaring extends CultureTrait
{
    /**
     * @return Collection<int, YieldModifiersFor>
     */
    public function yieldModifiersFors(): Collection
    {
        return collect([
            new YieldModifiersFor(
                collect([new YieldModifier(YieldType::Production, 1)]),
                Feature::Reef
            ),
            new YieldModifiersFor(
                collect([new YieldModifier(YieldType::Production, 1)]),
                Feature::Shoals
            ),
            new YieldModifiersFor(
                collect([new YieldModifier(YieldType::Gold, 1)]),
                ImprovementCategory::Fisheries
            )
        ]);
    }
}
