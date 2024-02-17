<?php

namespace App\Buildings\Faith;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Bronze\OrganizedReligion;
use App\Technologies\TechnologyType;

class Temple extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Faith;
    }

    public function technology(): ?TechnologyType
    {
        return OrganizedReligion::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return PriestsSchool::get();
    }
}
