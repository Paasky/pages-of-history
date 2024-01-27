<?php

namespace App\UnitEquipment\SkirmishFirearm;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Renaissance\Gunpowder;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Arquebus extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Skirmish;
    }

    public function technology(): ?TechnologyType
    {
        return Gunpowder::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return FlintlockCarbine::get();
    }
}
