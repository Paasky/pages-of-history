<?php

namespace App\Buildings\Happiness;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Bronze\CodeOfLaw;
use App\Technologies\TechnologyType;

class Courthouse extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Happiness;
    }

    public function technology(): ?TechnologyType
    {
        return CodeOfLaw::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Courthouse::get();
    }
}
