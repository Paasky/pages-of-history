<?php

namespace App\Buildings\Training;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Classical\MilitaryDiscipline;
use App\Technologies\TechnologyType;

class TrainingField extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::LandTraining;
    }

    public function technology(): ?TechnologyType
    {
        return MilitaryDiscipline::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Barracks::get();
    }
}
