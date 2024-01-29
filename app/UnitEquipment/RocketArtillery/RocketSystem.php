<?php

namespace App\UnitEquipment\RocketArtillery;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Digital\SatellitePositioning;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class RocketSystem extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::RocketArtillery;
    }

    public function technology(): ?TechnologyType
    {
        return SatellitePositioning::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return AiRocketSystem::get();
    }
}
