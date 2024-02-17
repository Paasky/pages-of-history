<?php

namespace App\Buildings\Gold;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Copper\Government;
use App\Technologies\TechnologyType;

class TaxCollector extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Gold;
    }

    public function technology(): ?TechnologyType
    {
        return Government::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Governor::get();
    }
}
