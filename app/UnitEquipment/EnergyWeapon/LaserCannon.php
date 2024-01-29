<?php

namespace App\UnitEquipment\EnergyWeapon;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Nano\WeaponizedLasers;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class LaserCannon extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::EnergyWeapon;
    }

    public function technology(): ?TechnologyType
    {
        return WeaponizedLasers::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return null;
    }
}
