<?php

namespace App\Buildings\Production;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\TechnologyType;

class AssemblyLine extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Production;
    }

    public function technology(): ?TechnologyType
    {
        return \App\Technologies\Modern\AssemblyLine::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return RoboticFactory::get();
    }
}
