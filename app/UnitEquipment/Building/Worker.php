<?php

namespace App\UnitEquipment\Building;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Worker extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Building;
    }

    public function technology(): ?TechnologyType
    {
        return null;
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Builder::get();
    }
}
