<?php

namespace App\Buildings\Training;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Modern\Radar;
use App\Technologies\TechnologyType;

class Airfield extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::AirTraining;
    }

    public function technology(): ?TechnologyType
    {
        return Radar::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return AirBase::get();
    }
}
