<?php

namespace App\Culture\Traits;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Agrarian extends CultureTrait
{
    /**
     * @return Collection<int, YieldModifiersFor>
     */
    public function yieldModifiersFors(): Collection
    {
        return collect([
            new YieldModifiersFor(
                collect([
                    new YieldModifier(YieldType::Food, 1),
                    new YieldModifier(YieldType::Happiness, 1),
                ]),
                ImprovementCategory::Farms
            ),
        ]);
    }
}
