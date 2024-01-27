<?php

namespace App\UnitEquipment\AntiTank;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Modern\AssaultTactics;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class AntiTankRifle extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::AntiTank;
    }

    public function technology(): ?TechnologyType
    {
        return AssaultTactics::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return RocketGrenade::get();
    }
}
