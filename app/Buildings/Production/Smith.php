<?php

namespace App\Buildings\Production;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Copper\CopperWorking;
use App\Technologies\TechnologyType;

class Smith extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Production;
    }

    public function technology(): ?TechnologyType
    {
        return CopperWorking::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Blacksmith::get();
    }
}
