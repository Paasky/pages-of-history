<?php

namespace App\Buildings\Science;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\HighMedieval\BookBinding;
use App\Technologies\TechnologyType;

class Bookmaker extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Science;
    }

    public function technology(): ?TechnologyType
    {
        return BookBinding::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Observatory::get();
    }
}
