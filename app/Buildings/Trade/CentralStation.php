<?php

namespace App\Buildings\Trade;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Industrial\Railroad;
use App\Technologies\TechnologyType;

class CentralStation extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::LandTrade;
    }

    public function technology(): ?TechnologyType
    {
        return Railroad::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Motorway::get();
    }
}
