<?php

namespace App\Buildings\Production;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Iron\IronWorking;
use App\Technologies\TechnologyType;

class Blacksmith extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Production;
    }

    public function technology(): ?TechnologyType
    {
        return IronWorking::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return BlastFurnace::get();
    }
}
