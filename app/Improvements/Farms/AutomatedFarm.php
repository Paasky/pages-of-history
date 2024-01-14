<?php

namespace App\Improvements\Farms;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Information\AutonomousRobotics;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class AutomatedFarm extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Farms;
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
            new YieldModifier(YieldType::Food, 6),
        ]);
    }
}
