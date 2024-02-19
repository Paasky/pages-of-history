<?php

namespace App\Buildings\Training;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Enums\Domain;
use App\Enums\YieldType;
use App\Technologies\Atomic\GuidanceSystems;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use App\Yields\YieldModifiersTowards;
use Illuminate\Support\Collection;

class AirBase extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::AirTraining;
    }

    public function technology(): ?TechnologyType
    {
        return GuidanceSystems::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return null;
    }

    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Cost, $this->technology()->era()->baseCost()),
            new YieldModifier($this, YieldType::Gold, -6),
            new YieldModifiersFor(
                new YieldModifier($this, YieldType::Capacity, 8),
                Domain::Air
            ),
            new YieldModifiersTowards(
                new YieldModifier($this, YieldType::Production, percent: 25),
                Domain::Air
            ),
        ]);
    }
}
