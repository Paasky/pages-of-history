<?php

namespace App\Improvements\Plantations;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Industrial\Fertilizer;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class FertilizedPlantation extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Plantations;
    }

    public function technology(): ?TechnologyType
    {
        return Fertilizer::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return MechanizedPlantation::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier(YieldType::Food, 2),
            new YieldModifier(YieldType::Gold, 2),
        ]);
    }
}
