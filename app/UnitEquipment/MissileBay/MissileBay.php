<?php

namespace App\UnitEquipment\MissileBay;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Atomic\OrbitalBallistics;
use App\Technologies\Industrial\Rifling;
use App\Technologies\TechnologyType;
use App\UnitEquipment\Firearm\RepeatingRifle;
use App\UnitEquipment\UnitEquipmentType;

class MissileBay extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::MissileBay;
    }

    public function technology(): ?TechnologyType
    {
        return OrbitalBallistics::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return null;
    }
}
