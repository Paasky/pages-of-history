<?php

namespace App\Buildings\Science;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Enlightenment\Education;
use App\Technologies\TechnologyType;

class University extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Science;
    }

    public function technology(): ?TechnologyType
    {
        return Education::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return PublicLibrary::get();
    }
}
