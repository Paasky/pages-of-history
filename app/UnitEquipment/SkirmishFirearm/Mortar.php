<?php

namespace App\UnitEquipment\SkirmishFirearm;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Modern\Rocketry;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Mortar extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::SkirmishFirearm;
    }

    public function technology(): ?TechnologyType
    {
        return Rocketry::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return GuidedMortar::get();
    }
}
