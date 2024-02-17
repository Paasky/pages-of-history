<?php

namespace App\Buildings\Production;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Industrial\Industrialization;
use App\Technologies\TechnologyType;

class Factory extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Production;
    }

    public function technology(): ?TechnologyType
    {
        return Industrialization::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return SteelWorks::get();
    }
}
