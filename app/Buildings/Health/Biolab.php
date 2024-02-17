<?php

namespace App\Buildings\Health;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Digital\Biotech;
use App\Technologies\TechnologyType;

class Biolab extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Health;
    }

    public function technology(): ?TechnologyType
    {
        return Biotech::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return VaccinePlant::get();
    }
}
