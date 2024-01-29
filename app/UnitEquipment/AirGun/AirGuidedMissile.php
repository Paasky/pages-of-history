<?php

namespace App\UnitEquipment\AirGun;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Digital\Lasers;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class AirGuidedMissile extends UnitEquipmentType
{
    public int $weight = 1;

    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::AirGun;
    }

    public function technology(): ?TechnologyType
    {
        return Lasers::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return AirAiMissile::get();
    }
}
