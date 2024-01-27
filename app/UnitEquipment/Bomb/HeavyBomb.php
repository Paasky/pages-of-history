<?php

namespace App\UnitEquipment\Bomb;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Modern\Radar;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class HeavyBomb extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Bomb;
    }

    public function technology(): ?TechnologyType
    {
        return Radar::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return GuidedBomb::get();
    }
}
