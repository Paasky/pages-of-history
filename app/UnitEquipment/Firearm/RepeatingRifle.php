<?php

namespace App\UnitEquipment\Firearm;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Gilded\SmokelessPowder;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class RepeatingRifle extends UnitEquipmentType
{
    public int $weight = 1;

    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Firearm;
    }

    public function technology(): ?TechnologyType
    {
        return SmokelessPowder::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return AssaultRifle::get();
    }
}
