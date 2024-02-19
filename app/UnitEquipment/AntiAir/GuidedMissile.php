<?php

namespace App\UnitEquipment\AntiAir;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Digital\Lasers;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class GuidedMissile extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::AntiAir;
    }

    public function technology(): ?TechnologyType
    {
        return Lasers::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return AntiAirLaser::get();
    }
}
