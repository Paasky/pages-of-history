<?php

namespace App\Buildings\Culture;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Gilded\Radio;
use App\Technologies\TechnologyType;

class RadioTower extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Culture;
    }

    public function technology(): ?TechnologyType
    {
        return Radio::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return TvTower::get();
    }
}
