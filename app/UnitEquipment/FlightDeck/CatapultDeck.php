<?php

namespace App\UnitEquipment\FlightDeck;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Modern\JetEngine;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class CatapultDeck extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::FlightDeck;
    }

    public function technology(): ?TechnologyType
    {
        return JetEngine::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return RadarDeck::get();
    }
}
