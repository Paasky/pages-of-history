<?php

namespace App\Buildings\Production;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Atomic\Robotics;
use App\Technologies\TechnologyType;

class RoboticFactory extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Production;
    }

    public function technology(): ?TechnologyType
    {
        return Robotics::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return null;
    }
}
