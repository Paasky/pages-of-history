<?php

namespace App\Buildings\Health;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Information\MrnaVaccines;
use App\Technologies\TechnologyType;

class VaccinePlant extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Health;
    }

    public function technology(): ?TechnologyType
    {
        return MrnaVaccines::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return null;
    }
}
