<?php

namespace App\UnitEquipment\Firearm;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Enlightenment\Chemistry;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class FlintlockMusket extends UnitEquipmentType
{
    public int $weight = 1;

    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Firearm;
    }

    public function technology(): ?TechnologyType
    {
        return Chemistry::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return RifleMusket::get();
    }
}
