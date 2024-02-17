<?php

namespace App\Buildings\Faith;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Neolithic\Mysticism;
use App\Technologies\TechnologyType;

class Shrine extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Faith;
    }

    public function technology(): ?TechnologyType
    {
        return Mysticism::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Temple::get();
    }
}
