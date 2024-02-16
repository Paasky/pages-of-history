<?php

namespace App\UnitEquipment\RocketArtillery;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Atomic\OrbitalBallistics;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class RocketArtillery extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::RocketArtillery;
    }

    public function technology(): ?TechnologyType
    {
        return OrbitalBallistics::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return RocketSystem::get();
    }
}
