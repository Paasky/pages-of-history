<?php

namespace App\UnitEquipment\AntiTankGun;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Atomic\Computers;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class HighVelocityGun extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::AntiTankGun;
    }

    public function technology(): ?TechnologyType
    {
        return Computers::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return SmoothBoreGun::get();
    }
}
