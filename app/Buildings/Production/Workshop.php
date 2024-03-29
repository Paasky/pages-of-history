<?php

namespace App\Buildings\Production;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Renaissance\MassProduction;
use App\Technologies\TechnologyType;

class Workshop extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Production;
    }

    public function technology(): ?TechnologyType
    {
        return MassProduction::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Manufactury::get();
    }
}
