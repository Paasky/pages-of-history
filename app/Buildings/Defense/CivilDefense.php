<?php

namespace App\Buildings\Defense;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Atomic\NuclearFission;
use App\Technologies\TechnologyType;

class CivilDefense extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Defense;
    }

    public function technology(): ?TechnologyType
    {
        return NuclearFission::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return null;
    }
}
