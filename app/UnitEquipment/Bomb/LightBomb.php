<?php

namespace App\UnitEquipment\Bomb;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Modern\AssaultTactics;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class LightBomb extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Bomb;
    }

    public function technology(): ?TechnologyType
    {
        return AssaultTactics::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return HeavyBomb::get();
    }
}
