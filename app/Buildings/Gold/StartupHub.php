<?php

namespace App\Buildings\Gold;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Information\Crowdsourcing;
use App\Technologies\TechnologyType;

class StartupHub extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Gold;
    }

    public function technology(): ?TechnologyType
    {
        return Crowdsourcing::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return null;
    }
}
