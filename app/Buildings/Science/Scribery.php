<?php

namespace App\Buildings\Science;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Bronze\Writing;
use App\Technologies\TechnologyType;

class Scribery extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Science;
    }

    public function technology(): ?TechnologyType
    {
        return Writing::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Library::get();
    }
}
