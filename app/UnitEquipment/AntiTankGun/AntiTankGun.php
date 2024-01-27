<?php

namespace App\UnitEquipment\AntiTankGun;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Modern\AssaultTactics;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class AntiTankGun extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::AntiTankGun;
    }

    public function technology(): ?TechnologyType
    {
        return AssaultTactics::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return HighVelocityGun::get();
    }
}
