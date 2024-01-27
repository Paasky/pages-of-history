<?php

namespace App\UnitEquipment\Ranged;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Copper\Archery;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Bow extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Ranged;
    }

    public function technology(): ?TechnologyType
    {
        return Archery::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return CompositeBow::get();
    }
}
