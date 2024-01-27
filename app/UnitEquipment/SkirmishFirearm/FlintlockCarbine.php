<?php

namespace App\UnitEquipment\SkirmishFirearm;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Enlightenment\Chemistry;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class FlintlockCarbine extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::SkirmishFirearm;
    }

    public function technology(): ?TechnologyType
    {
        return Chemistry::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return RifleCarbine::get();
    }
}
