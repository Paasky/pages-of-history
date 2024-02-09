<?php

namespace App\UnitEquipment\Bomb;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Atomic\GuidanceSystems;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class GuidedBomb extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::AirBomb;
    }

    public function technology(): ?TechnologyType
    {
        return GuidanceSystems::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return AiGuidedBomb::get();
    }
}
