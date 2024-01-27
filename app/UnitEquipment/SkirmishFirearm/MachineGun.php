<?php

namespace App\UnitEquipment\SkirmishFirearm;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Gilded\ReplaceableParts;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class MachineGun extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Skirmish;
    }

    public function technology(): ?TechnologyType
    {
        return ReplaceableParts::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Mortar::get();
    }
}
