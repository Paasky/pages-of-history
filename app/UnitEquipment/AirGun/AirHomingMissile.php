<?php

namespace App\UnitEquipment\AirGun;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Atomic\Transistor;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class AirHomingMissile extends UnitEquipmentType
{
    public int $weight = 1;

    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::AirGun;
    }

    public function technology(): ?TechnologyType
    {
        return Transistor::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return AirGuidedMissile::get();
    }
}
