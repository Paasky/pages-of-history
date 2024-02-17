<?php

namespace App\Buildings\Training;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Atomic\GuidanceSystems;
use App\Technologies\TechnologyType;

class AirBase extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::AirTraining;
    }

    public function technology(): ?TechnologyType
    {
        return GuidanceSystems::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return null;
    }
}
