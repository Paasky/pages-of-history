<?php

namespace App\UnitEquipment\AntiAir;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Gilded\Ballistics;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class AntiAirGun extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::AntiAir;
    }

    public function technology(): ?TechnologyType
    {
        return Ballistics::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return HomingMissile::get();
    }
}
