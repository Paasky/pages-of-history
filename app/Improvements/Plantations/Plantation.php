<?php

namespace App\Improvements\Plantations;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Copper\Astrology;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class Plantation extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Plantations;
    }

    public function technology(): ?TechnologyType
    {
        return Astrology::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return IrrigatedPlantation::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier(YieldType::Food, 0.5),
            new YieldModifier(YieldType::Gold, 0.5),
        ]);
    }
}
