<?php

namespace App\UnitEquipment\Melee;

use App\Enums\UnitEquipmentCategory;
use App\UnitEquipment\UnitEquipmentType;

class StoneAxe extends UnitEquipmentType
{
    public int $weight = 1;

    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Melee;
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return BronzeSword::get();
    }
}
