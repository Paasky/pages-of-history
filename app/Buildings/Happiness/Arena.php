<?php

namespace App\Buildings\Happiness;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Iron\Sports;
use App\Technologies\TechnologyType;

class Arena extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Happiness;
    }

    public function technology(): ?TechnologyType
    {
        return Sports::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return TownHall::get();
    }
}
