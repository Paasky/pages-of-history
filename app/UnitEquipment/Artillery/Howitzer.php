<?php

namespace App\UnitEquipment\Artillery;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Modern\Militarism;
use App\Technologies\TechnologyType;
use App\UnitEquipment\RocketArtillery\RocketArtillery;
use App\UnitEquipment\UnitEquipmentType;

class Howitzer extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Artillery;
    }

    public function technology(): ?TechnologyType
    {
        return Militarism::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return RocketArtillery::get();
    }
}
