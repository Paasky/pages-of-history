<?php

namespace App\Buildings\Science;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Gilded\Socialism;
use App\Technologies\TechnologyType;

class PublicLibrary extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Science;
    }

    public function technology(): ?TechnologyType
    {
        return Socialism::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return ResearchInstitute::get();
    }
}
