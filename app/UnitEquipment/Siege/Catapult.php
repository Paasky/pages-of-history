<?php

namespace App\UnitEquipment\Siege;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Iron\Mathematics;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Catapult extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Siege;
    }

    public function technology(): ?TechnologyType
    {
        return Mathematics::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Onager::get();
    }
}
