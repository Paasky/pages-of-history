<?php

namespace App\UnitEquipment\NavalAssault;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Industrial\Rifling;
use App\Technologies\TechnologyType;
use App\UnitEquipment\Torpedo\Torpedo;
use App\UnitEquipment\UnitEquipmentType;

class MusketMarines extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::NavalAssault;
    }

    public function technology(): ?TechnologyType
    {
        return Rifling::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Torpedo::get();
    }
}
