<?php

namespace App\Buildings\Health;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Iron\Construction;
use App\Technologies\TechnologyType;

class Aqueduct extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Health;
    }

    public function technology(): ?TechnologyType
    {
        return Construction::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return BathHouse::get();
    }
}
