<?php

namespace App\UnitEquipment\Expansion;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Industrial\Nationalism;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Pioneer extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Expansion;
    }

    public function technology(): ?TechnologyType
    {
        return Nationalism::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return null;
    }
}
