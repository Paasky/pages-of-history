<?php

namespace App\UnitEquipment\AirGun;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Nano\ArtificialIntelligence;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class AirAiMissile extends UnitEquipmentType
{
    public int $weight = 1;

    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::AirGun;
    }

    public function technology(): ?TechnologyType
    {
        return ArtificialIntelligence::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return null;
    }
}
