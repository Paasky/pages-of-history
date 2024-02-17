<?php

namespace App\Improvements\Farms;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Bronze\Irrigation;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class IrrigatedFarm extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Farms;
    }

    public function technology(): ?TechnologyType
    {
        return Irrigation::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return FeudalFarm::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Food, 2),
        ]);
    }
}
