<?php

namespace App\UnitEquipment\Siege;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Classical\TreadwheelCrane;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Onager extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Siege;
    }

    public function technology(): ?TechnologyType
    {
        return TreadwheelCrane::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Trebuchet::get();
    }
}
