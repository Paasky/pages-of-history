<?php

namespace App\UnitEquipment\Espionage;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Medieval\DivineRight;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Courtesan extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Espionage;
    }

    public function technology(): ?TechnologyType
    {
        return DivineRight::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Spy::get();
    }
}
