<?php

namespace App\Buildings\Defense;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\HighMedieval\SiegeTactics;
use App\Technologies\TechnologyType;

class SiegeWalls extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Defense;
    }

    public function technology(): ?TechnologyType
    {
        return SiegeTactics::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Trenches::get();
    }
}
