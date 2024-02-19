<?php

namespace App\Buildings\Faith;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\HighMedieval\Chivalry;
use App\Technologies\TechnologyType;

class Monastery extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Faith;
    }

    public function technology(): ?TechnologyType
    {
        return Chivalry::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Cathedral::get();
    }
}
