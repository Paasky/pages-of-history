<?php

namespace App\Buildings\Production;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Enlightenment\Economics;
use App\Technologies\TechnologyType;

class Manufactury extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Production;
    }

    public function technology(): ?TechnologyType
    {
        return Economics::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Factory::get();
    }
}
