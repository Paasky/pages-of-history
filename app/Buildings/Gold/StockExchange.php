<?php

namespace App\Buildings\Gold;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Enlightenment\Corporation;
use App\Technologies\TechnologyType;

class StockExchange extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Gold;
    }

    public function technology(): ?TechnologyType
    {
        return Corporation::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return StartupHub::get();
    }
}
