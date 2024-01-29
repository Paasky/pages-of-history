<?php

namespace App\UnitEquipment\Firearm;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Nano\WeaponizedLasers;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class LaserRifle extends UnitEquipmentType
{
    public int $weight = 1;

    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Firearm;
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
