<?php

namespace App\Buildings\Food;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Industrial\Fertilizer;
use App\Technologies\TechnologyType;

class GrainElevator extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Food;
    }

    public function technology(): ?TechnologyType
    {
        return Fertilizer::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return DepartmentStore::get();
    }
}
