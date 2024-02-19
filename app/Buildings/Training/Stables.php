<?php

namespace App\Buildings\Training;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\Technologies\Iron\HorsebackRiding;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use App\Yields\YieldModifiersTowards;
use Illuminate\Support\Collection;

class Stables extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::LandTraining;
    }

    public function technology(): ?TechnologyType
    {
        return HorsebackRiding::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return RecruitmentOffice::get();
    }

    /**
     * @return Collection<int, YieldModifiersFor>
     */
    public function yieldModifiers(): Collection
    {

        return collect([
            new YieldModifier($this, YieldType::Cost, $this->technology()->era()->baseCost()),
            new YieldModifier($this, YieldType::Gold, -2),
            new YieldModifier($this, YieldType::Production, 1),
            new YieldModifiersTowards(
                new YieldModifier($this, YieldType::Production, percent: 25),
                UnitPlatformCategory::Mounted
            ),
        ]);
    }
}
