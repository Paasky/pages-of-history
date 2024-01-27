<?php

namespace App\UnitEquipment\Building;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Modern\AssemblyLine;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Tractor extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Building;
    }

    public function technology(): ?TechnologyType
    {
        return AssemblyLine::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Excavator::get();
    }
}
