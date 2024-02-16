<?php

namespace App\Buildings\Science;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Renaissance\Astronomy;
use App\Technologies\TechnologyType;

class Observatory extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Science;
    }

    public function technology(): ?TechnologyType
    {
        return Astronomy::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return University::get();
    }
}
