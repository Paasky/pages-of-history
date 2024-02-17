<?php

namespace App\Buildings\Training;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Modern\AssaultTactics;
use App\Technologies\TechnologyType;

class RecruitmentOffice extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::LandTraining;
    }

    public function technology(): ?TechnologyType
    {
        return AssaultTactics::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return null;
    }
}
