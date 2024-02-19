<?php

namespace App\Buildings\Production;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Medieval\MetalCasting;
use App\Technologies\TechnologyType;

class BlastFurnace extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Production;
    }

    public function technology(): ?TechnologyType
    {
        return MetalCasting::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Workshop::get();
    }
}
