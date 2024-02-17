<?php

namespace App\Buildings\Trade;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Classical\Engineering;
use App\Technologies\TechnologyType;

class Lighthouse extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::SeaTrade;
    }

    public function technology(): ?TechnologyType
    {
        return Engineering::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Port::get();
    }
}
