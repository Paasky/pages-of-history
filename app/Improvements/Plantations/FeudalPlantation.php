<?php

namespace App\Improvements\Plantations;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Medieval\CropRotation;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class FeudalPlantation extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Plantations;
    }

    public function technology(): ?TechnologyType
    {
        return CropRotation::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return FertilizedPlantation::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Food, 1.5),
            new YieldModifier($this, YieldType::Gold, 1.5),
        ]);
    }
}
