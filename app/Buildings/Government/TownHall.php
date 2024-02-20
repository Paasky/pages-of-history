<?php

namespace App\Buildings\Government;

use App\Buildings\BuildingType;
use App\Buildings\Happiness\CoffeeHouse;
use App\Enums\BuildingCategory;
use App\Technologies\Medieval\CivilService;
use App\Technologies\TechnologyType;

class TownHall extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Government;
    }

    public function technology(): ?TechnologyType
    {
        return CivilService::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return CoffeeHouse::get();
    }
}
