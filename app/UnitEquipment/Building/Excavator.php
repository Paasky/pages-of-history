<?php

namespace App\UnitEquipment\Building;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Atomic\Plastics;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Excavator extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Building;
    }

    public function technology(): ?TechnologyType
    {
        return Plastics::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return null;
    }
}
