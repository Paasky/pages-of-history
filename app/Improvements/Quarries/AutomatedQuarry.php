<?php

namespace App\Improvements\Quarries;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Information\AutonomousRobotics;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class AutomatedQuarry extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Quarries;
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
            new YieldModifier(YieldType::Gold, 3),
            new YieldModifier(YieldType::Production, 3),
        ]);
    }
}
