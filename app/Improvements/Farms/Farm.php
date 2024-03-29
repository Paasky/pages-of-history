<?php

namespace App\Improvements\Farms;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Neolithic\Agriculture;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class Farm extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Farms;
    }

    public function technology(): ?TechnologyType
    {
        return Agriculture::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return IrrigatedFarm::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Food, 1),
        ]);
    }
}
