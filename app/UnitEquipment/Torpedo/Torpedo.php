<?php

namespace App\UnitEquipment\Torpedo;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Modern\HydroEngineering;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Torpedo extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Torpedo;
    }

    public function technology(): ?TechnologyType
    {
        return HydroEngineering::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return HomingTorpedo::get();
    }
}
