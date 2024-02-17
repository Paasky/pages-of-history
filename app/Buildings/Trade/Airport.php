<?php

namespace App\Buildings\Trade;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Atomic\Transistor;
use App\Technologies\TechnologyType;

class Airport extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::AirTrade;
    }

    public function technology(): ?TechnologyType
    {
        return Transistor::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return HubAirport::get();
    }
}
