<?php

namespace App\UnitEquipment\SkirmishFirearm;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Industrial\Rifling;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class RifleCarbine extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Skirmish;
    }

    public function technology(): ?TechnologyType
    {
        return Rifling::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return MachineGun::get();
    }
}
