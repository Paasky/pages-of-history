<?php

namespace App\Buildings\Culture;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Renaissance\Printing;
use App\Technologies\TechnologyType;

class PrintingPress extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Culture;
    }

    public function technology(): ?TechnologyType
    {
        return Printing::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Theater::get();
    }
}
