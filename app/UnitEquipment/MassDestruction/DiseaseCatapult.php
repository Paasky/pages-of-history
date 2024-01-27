<?php

namespace App\UnitEquipment\MassDestruction;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Medieval\DivineRight;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class DiseaseCatapult extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::MassDestruction;
    }

    public function technology(): ?TechnologyType
    {
        return DivineRight::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return GasBomb::get();
    }
}
