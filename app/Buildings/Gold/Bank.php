<?php

namespace App\Buildings\Gold;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Renaissance\Banking;
use App\Technologies\TechnologyType;

class Bank extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Gold;
    }

    public function technology(): ?TechnologyType
    {
        return Banking::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return StockExchange::get();
    }
}
