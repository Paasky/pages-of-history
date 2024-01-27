<?php

namespace App\UnitEquipment\AntiTankGun;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Digital\Composites;
use App\Technologies\TechnologyType;
use App\UnitEquipment\EnergyWeapon\Railgun;
use App\UnitEquipment\UnitEquipmentType;

class SmoothBoreGun extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::AntiTankGun;
    }

    public function technology(): ?TechnologyType
    {
        return Composites::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Railgun::get();
    }
}
