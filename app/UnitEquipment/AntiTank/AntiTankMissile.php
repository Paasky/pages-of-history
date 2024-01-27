<?php

namespace App\UnitEquipment\AntiTank;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Digital\Lasers;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class AntiTankMissile extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::AntiTank;
    }

    public function technology(): ?TechnologyType
    {
        return Lasers::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return null;
    }
}
