<?php

namespace App\Buildings\Science;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Classical\Philosophy;
use App\Technologies\TechnologyType;

class PhilosophersSchool extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Science;
    }

    public function technology(): ?TechnologyType
    {
        return Philosophy::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Bookmaker::get();
    }
}
