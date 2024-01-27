<?php

namespace App\UnitEquipment\FlightDeck;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Digital\Microchips;
use App\Technologies\Digital\SatellitePositioning;
use App\Technologies\Industrial\Rifling;
use App\Technologies\TechnologyType;
use App\UnitEquipment\Firearm\RepeatingRifle;
use App\UnitEquipment\UnitEquipmentType;

class RadarDeck extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::FlightDeck;
    }

    public function technology(): ?TechnologyType
    {
        return SatellitePositioning::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return AiRadarDeck::get();
    }
}
