<?php

namespace App\Buildings\Culture;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Bronze\Masonry;
use App\Technologies\TechnologyType;

class Pyramid extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Culture;
    }

    public function technology(): ?TechnologyType
    {
        return Masonry::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Amphitheater::get();
    }
}
