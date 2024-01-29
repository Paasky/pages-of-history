<?php

namespace App\UnitEquipment\FlightDeck;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Modern\Electronics;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class WoodenDeck extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::FlightDeck;
    }

    public function technology(): ?TechnologyType
    {
        return Electronics::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return CatapultDeck::get();
    }
}
