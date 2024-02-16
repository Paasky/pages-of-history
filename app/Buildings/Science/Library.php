<?php

namespace App\Buildings\Science;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Iron\Alphabet;
use App\Technologies\TechnologyType;

class Library extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Science;
    }

    public function technology(): ?TechnologyType
    {
        return Alphabet::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return PhilosophersSchool::get();
    }
}
