<?php

namespace App\Buildings\Culture;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Classical\DramaAndPoetry;
use App\Technologies\TechnologyType;

class Amphitheater extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Culture;
    }

    public function technology(): ?TechnologyType
    {
        return DramaAndPoetry::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return PrintingPress::get();
    }
}
