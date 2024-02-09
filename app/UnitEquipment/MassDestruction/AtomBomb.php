<?php

namespace App\UnitEquipment\MassDestruction;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Atomic\NuclearFission;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class AtomBomb extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::MassDestruction;
    }

    public function technology(): ?TechnologyType
    {
        return NuclearFission::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return null;
    }
}
