<?php

namespace App\Buildings\Trade;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Copper\Sailing;
use App\Technologies\TechnologyType;

class Pier extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::SeaTrade;
    }

    public function technology(): ?TechnologyType
    {
        return Sailing::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Harbor::get();
    }
}
