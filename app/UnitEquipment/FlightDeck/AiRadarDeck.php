<?php

namespace App\UnitEquipment\FlightDeck;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Nano\NeuralNetworks;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class AiRadarDeck extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::FlightDeck;
    }

    public function technology(): ?TechnologyType
    {
        return NeuralNetworks::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return null;
    }
}
