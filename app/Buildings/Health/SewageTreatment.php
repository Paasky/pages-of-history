<?php

namespace App\Buildings\Health;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Atomic\Ecology;
use App\Technologies\TechnologyType;

class SewageTreatment extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Health;
    }

    public function technology(): ?TechnologyType
    {
        return Ecology::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Biolab::get();
    }
}
