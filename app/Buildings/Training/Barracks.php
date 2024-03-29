<?php

namespace App\Buildings\Training;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Industrial\Conscription;
use App\Technologies\TechnologyType;

class Barracks extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::LandTraining;
    }

    public function technology(): ?TechnologyType
    {
        return Conscription::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return RecruitmentOffice::get();
    }
}
