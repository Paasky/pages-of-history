<?php

namespace App\Buildings\Training;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Renaissance\SquareRigging;
use App\Technologies\TechnologyType;

class Drydock extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::SeaTraining;
    }

    public function technology(): ?TechnologyType
    {
        return SquareRigging::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Shipyard::get();
    }
}
