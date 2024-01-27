<?php

namespace App\UnitEquipment\AntiTank;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Modern\CombinedArms;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class RocketGrenade extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::AntiTank;
    }

    public function technology(): ?TechnologyType
    {
        return CombinedArms::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return AntiTankMissile::get();
    }
}
