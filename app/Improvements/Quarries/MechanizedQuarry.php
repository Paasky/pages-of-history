<?php

namespace App\Improvements\Quarries;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Modern\HydroEngineering;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class MechanizedQuarry extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Quarries;
    }

    public function technology(): ?TechnologyType
    {
        return HydroEngineering::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return AutomatedQuarry::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Gold, 2.5),
            new YieldModifier($this, YieldType::Production, 2.5),
        ]);
    }
}
