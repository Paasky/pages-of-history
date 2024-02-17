<?php

namespace App\Buildings\Defense;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Neolithic\WoodWorking;
use App\Technologies\TechnologyType;

class Palisades extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Defense;
    }

    public function technology(): ?TechnologyType
    {
        return WoodWorking::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Walls::get();
    }
}
