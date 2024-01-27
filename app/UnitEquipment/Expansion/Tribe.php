<?php

namespace App\UnitEquipment\Expansion;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Tribe extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Expansion;
    }

    public function technology(): ?TechnologyType
    {
        return null;
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Settler::get();
    }
}
