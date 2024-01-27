<?php

namespace App\UnitEquipment\Torpedo;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Digital\Microchips;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class GuidedTorpedo extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Torpedo;
    }

    public function technology(): ?TechnologyType
    {
        return Microchips::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return AiTorpedo::get();
    }
}
