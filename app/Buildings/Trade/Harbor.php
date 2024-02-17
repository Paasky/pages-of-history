<?php

namespace App\Buildings\Trade;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Bronze\CelestialNavigation;
use App\Technologies\TechnologyType;

class Harbor extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::SeaTrade;
    }

    public function technology(): ?TechnologyType
    {
        return CelestialNavigation::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Lighthouse::get();
    }
}
