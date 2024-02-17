<?php

namespace App\Buildings\Training;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Gilded\SteelMilling;
use App\Technologies\TechnologyType;

class Shipyard extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::SeaTraining;
    }

    public function technology(): ?TechnologyType
    {
        return SteelMilling::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return null;
    }
}
