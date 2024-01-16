<?php

namespace App\Buildings\Trade;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Technologies\Classical\Engineering;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Lighthouse extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::SeaTrade;
    }

    public function technology(): ?TechnologyType
    {
        return Engineering::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Port::get();
    }

    /**
     * @return Collection<int, YieldModifiersFor>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifiersFor(
                collect([new YieldModifier(YieldType::Production, 1)]),
                ImprovementCategory::Fisheries
            ),
        ]);
    }
}
