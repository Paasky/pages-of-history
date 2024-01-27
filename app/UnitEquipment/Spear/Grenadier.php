<?php

namespace App\UnitEquipment\Spear;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Industrial\MilitaryScience;
use App\Technologies\TechnologyType;
use App\UnitEquipment\AntiTank\AntiTankRifle;
use App\UnitEquipment\UnitEquipmentType;

class Grenadier extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Spear;
    }

    public function technology(): ?TechnologyType
    {
        return MilitaryScience::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return AntiTankRifle::get();
    }
}
