<?php

namespace App\Buildings\Food;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Atomic\Plastics;
use App\Technologies\TechnologyType;

class Supermarket extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Food;
    }

    public function technology(): ?TechnologyType
    {
        return Plastics::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return null;
    }
}
