<?php

namespace App\Buildings\Trade;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Renaissance\Cartography;
use App\Technologies\TechnologyType;

class Port extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::SeaTrade;
    }

    public function technology(): ?TechnologyType
    {
        return Cartography::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return ContainerDock::get();
    }
}
