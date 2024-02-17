<?php

namespace App\Buildings\Defense;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Bronze\Sieging;
use App\Technologies\TechnologyType;

class Walls extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Defense;
    }

    public function technology(): ?TechnologyType
    {
        return Sieging::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Garrison::get();
    }
}
