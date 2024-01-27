<?php

namespace App\UnitEquipment\Firearm;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Industrial\Rifling;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class RifleMusket extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Firearm;
    }

    public function technology(): ?TechnologyType
    {
        return Rifling::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return RepeatingRifle::get();
    }
}
