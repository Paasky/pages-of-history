<?php

namespace App\Buildings\Happiness;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Medieval\CivilService;
use App\Technologies\TechnologyType;

class TownHall extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Happiness;
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
