<?php

namespace App\Buildings\Defense;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Gilded\SmokelessPowder;
use App\Technologies\TechnologyType;

class Trenches extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Defense;
    }

    public function technology(): ?TechnologyType
    {
        return SmokelessPowder::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return BombShelter::get();
    }
}
