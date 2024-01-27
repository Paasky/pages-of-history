<?php

namespace App\UnitEquipment\Ranged;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Neolithic\Trapping;
use App\Technologies\TechnologyType;
use App\UnitEquipment\Melee\BronzeSword;
use App\UnitEquipment\UnitEquipmentType;

class Sling extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Ranged;
    }

    public function technology(): ?TechnologyType
    {
        return Trapping::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Bow::get();
    }
}
