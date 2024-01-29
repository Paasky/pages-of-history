<?php

namespace App\UnitEquipment\EnergyWeapon;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Nano\Railguns;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Railgun extends UnitEquipmentType
{
    public int $weight = 3;

    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::EnergyWeapon;
    }

    public function technology(): ?TechnologyType
    {
        return Railguns::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return null;
    }
}
