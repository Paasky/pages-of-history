<?php

namespace App\UnitEquipment\Firearm;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Digital\Lasers;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class ScopeRifle extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Firearm;
    }

    public function technology(): ?TechnologyType
    {
        return Lasers::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return LaserRifle::get();
    }
}
