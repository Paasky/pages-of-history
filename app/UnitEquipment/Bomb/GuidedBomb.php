<?php

namespace App\UnitEquipment\Bomb;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Atomic\GuidanceSystems;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class GuidedBomb extends UnitEquipmentType
{
    public int $weight = 1;

    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Bomb;
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
