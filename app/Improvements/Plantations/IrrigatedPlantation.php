<?php

namespace App\Improvements\Plantations;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Bronze\Irrigation;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class IrrigatedPlantation extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Plantations;
    }

    public function technology(): ?TechnologyType
    {
        return Irrigation::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return FeudalPlantation::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Food, 1),
            new YieldModifier($this, YieldType::Gold, 1),
        ]);
    }
}
