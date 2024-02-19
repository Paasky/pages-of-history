<?php

namespace App\Buildings\Trade;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Enums\Domain;
use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Technologies\Bronze\CelestialNavigation;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Harbor extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::SeaTrade;
    }

    public function technology(): ?TechnologyType
    {
        return CelestialNavigation::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Lighthouse::get();
    }

    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Cost, $this->technology()->era()->baseCost()),
            new YieldModifiersFor(
                new YieldModifier($this, YieldType::Gold, 1),
                ImprovementCategory::Fisheries
            ),
            new YieldModifiersFor(
                new YieldModifier($this, YieldType::Trade, 2),
                Domain::Water
            ),
        ]);
    }
}
