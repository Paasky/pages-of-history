<?php

namespace App\Buildings\Health;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Bronze\Wheel;
use App\Technologies\TechnologyType;

class Garden extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Health;
    }

    public function technology(): ?TechnologyType
    {
        return Wheel::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Aqueduct::get();
    }
}
