<?php

namespace App\Buildings\Happiness;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Renaissance\Colonization;
use App\Technologies\TechnologyType;

class CoffeeHouse extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Happiness;
    }

    public function technology(): ?TechnologyType
    {
        return Colonization::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return StreetLighting::get();
    }
}
