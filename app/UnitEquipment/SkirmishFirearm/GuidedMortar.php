<?php

namespace App\UnitEquipment\SkirmishFirearm;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Atomic\GuidanceSystems;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class GuidedMortar extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::SkirmishFirearm;
    }

    public function technology(): ?TechnologyType
    {
        return GuidanceSystems::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return AiGuidedMortar::get();
    }
}
