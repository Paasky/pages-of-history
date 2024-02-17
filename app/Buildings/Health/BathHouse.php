<?php

namespace App\Buildings\Health;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Classical\GlassBlowing;
use App\Technologies\TechnologyType;

class BathHouse extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Health;
    }

    public function technology(): ?TechnologyType
    {
        return GlassBlowing::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return DoctorsGuild::get();
    }
}
