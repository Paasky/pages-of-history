<?php

namespace App\Buildings\Food;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Neolithic\Pottery;
use App\Technologies\TechnologyType;

class Granary extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Food;
    }

    public function technology(): ?TechnologyType
    {
        return Pottery::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return MarketSquare::get();
    }
}
