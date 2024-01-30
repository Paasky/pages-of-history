<?php

namespace App\UnitEquipment\Bomb;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Modern\AssaultTactics;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class LightBomb extends UnitEquipmentType
{
    public int $weight = 1;

    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::AirBomb;
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
