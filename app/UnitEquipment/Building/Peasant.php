<?php

namespace App\UnitEquipment\Building;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Medieval\Feudalism;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Peasant extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Building;
    }

    public function technology(): ?TechnologyType
    {
        return Feudalism::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Engineer::get();
    }
}
