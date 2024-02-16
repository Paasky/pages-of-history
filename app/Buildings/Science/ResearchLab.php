<?php

namespace App\Buildings\Science;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Atomic\Computers;
use App\Technologies\TechnologyType;

class ResearchLab extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Science;
    }

    public function technology(): ?TechnologyType
    {
        return Computers::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return QuantumComputer::get();
    }
}
