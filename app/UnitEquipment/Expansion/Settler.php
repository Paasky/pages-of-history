<?php

namespace App\UnitEquipment\Expansion;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Copper\Government;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Settler extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Expansion;
    }

    public function technology(): ?TechnologyType
    {
        return Government::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Colonist::get();
    }
}
