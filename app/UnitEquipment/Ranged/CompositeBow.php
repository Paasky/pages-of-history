<?php

namespace App\UnitEquipment\Ranged;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class CompositeBow extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Ranged;
    }

    public function technology(): ?TechnologyType
    {
        return \App\Technologies\Classical\CompositeBow::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Longbow::get();
    }
}
