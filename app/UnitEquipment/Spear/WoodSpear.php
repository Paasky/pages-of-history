<?php

namespace App\UnitEquipment\Spear;

use App\Enums\UnitEquipmentCategory;
use App\UnitEquipment\UnitEquipmentType;

class WoodSpear extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Spear;
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return BronzeSpear::get();
    }
}
