<?php

namespace App\Improvements\Fisheries;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Information\AutonomousRobotics;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class AutomatedFishery extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Fisheries;
    }

    public function technology(): ?TechnologyType
    {
        return AutonomousRobotics::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return null;
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Food, 3),
            new YieldModifier($this, YieldType::Gold, 3),
        ]);
    }
}
