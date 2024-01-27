<?php

namespace App\UnitEquipment\MassDestruction;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Digital\Genetics;
use App\Technologies\Industrial\Rifling;
use App\Technologies\TechnologyType;
use App\UnitEquipment\Firearm\RepeatingRifle;
use App\UnitEquipment\UnitEquipmentType;

class VirusBomb extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::MassDestruction;
    }

    public function technology(): ?TechnologyType
    {
        return Genetics::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return null;
    }
}
