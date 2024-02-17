<?php

namespace App\Buildings\Health;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Enlightenment\Liberalism;
use App\Technologies\TechnologyType;

class Hospital extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Health;
    }

    public function technology(): ?TechnologyType
    {
        return Liberalism::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Sewer::get();
    }
}
