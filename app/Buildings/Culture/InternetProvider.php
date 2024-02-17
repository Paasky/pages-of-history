<?php

namespace App\Buildings\Culture;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Digital\Internet;
use App\Technologies\TechnologyType;

class InternetProvider extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Culture;
    }

    public function technology(): ?TechnologyType
    {
        return Internet::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return null;
    }
}
