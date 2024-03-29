<?php

namespace App\Buildings\Culture;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Copper\Astrology;
use App\Technologies\TechnologyType;

class Monument extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Culture;
    }

    public function technology(): ?TechnologyType
    {
        return Astrology::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Pyramid::get();
    }
}
