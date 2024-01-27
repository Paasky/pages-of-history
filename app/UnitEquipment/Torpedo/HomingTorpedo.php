<?php

namespace App\UnitEquipment\Torpedo;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Atomic\Transistor;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class HomingTorpedo extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Torpedo;
    }

    public function technology(): ?TechnologyType
    {
        return Transistor::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return GuidedTorpedo::get();
    }
}
