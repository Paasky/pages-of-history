<?php

namespace App\UnitEquipment\AntiAir;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Atomic\Transistor;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class HomingMissile extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::AntiAir;
    }

    public function technology(): ?TechnologyType
    {
        return Transistor::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return GuidedMissile::get();
    }
}
