<?php

namespace App\Buildings\Culture;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Atomic\Telecommunications;
use App\Technologies\TechnologyType;

class TvTower extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Culture;
    }

    public function technology(): ?TechnologyType
    {
        return Telecommunications::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return InternetProvider::get();
    }
}
