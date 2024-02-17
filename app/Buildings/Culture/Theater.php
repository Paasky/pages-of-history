<?php

namespace App\Buildings\Culture;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\TechnologyType;

class Theater extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Culture;
    }

    public function technology(): ?TechnologyType
    {
        return \App\Technologies\Enlightenment\Theater::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Telegraph::get();
    }
}
