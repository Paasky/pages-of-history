<?php

namespace App\Improvements\Fisheries;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Iron\ShipBuilding;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class Fishery extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Fisheries;
    }

    public function technology(): ?TechnologyType
    {
        return ShipBuilding::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return FeudalFishery::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier(YieldType::Food, 1.5),
            new YieldModifier(YieldType::Gold, 1.5),
        ]);
    }
}
