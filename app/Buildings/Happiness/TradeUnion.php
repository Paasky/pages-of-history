<?php

namespace App\Buildings\Happiness;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Gilded\Socialism;
use App\Technologies\TechnologyType;

class TradeUnion extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Happiness;
    }

    public function technology(): ?TechnologyType
    {
        return Socialism::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Metro::get();
    }
}
