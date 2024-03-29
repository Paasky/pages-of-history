<?php

namespace App\Buildings\Defense;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Classical\ProfessionalArmy;
use App\Technologies\TechnologyType;

class Garrison extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Defense;
    }

    public function technology(): ?TechnologyType
    {
        return ProfessionalArmy::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return SiegeWalls::get();
    }
}
