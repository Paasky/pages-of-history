<?php

namespace App\Buildings\Science;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Modern\Electronics;
use App\Technologies\TechnologyType;

class ResearchInstitute extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Science;
    }

    public function technology(): ?TechnologyType
    {
        return Electronics::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return ResearchLab::get();
    }
}
