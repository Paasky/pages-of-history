<?php

namespace App\Buildings\Food;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Bronze\Currency;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class MarketSquare extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Food;
    }

    public function technology(): ?TechnologyType
    {
        return Currency::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return GrainElevator::get();
    }

    /**
     * @return Collection<int, YieldModifiersFor>
     */
    public function yieldModifiers(): Collection
    {
        return collect([

        ]);
    }
}
