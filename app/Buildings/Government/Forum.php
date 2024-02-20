<?php

namespace App\Buildings\Government;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Iron\MarbleSculpting;
use App\Technologies\TechnologyType;

class Forum extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Government;
    }

    public function technology(): ?TechnologyType
    {
        return MarbleSculpting::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return TownHall::get();
    }
}
