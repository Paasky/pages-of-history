<?php

namespace App\UnitEquipment\Melee;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Renaissance\Banking;
use App\Technologies\TechnologyType;
use App\UnitEquipment\Firearm\FlintlockMusket;
use App\UnitEquipment\UnitEquipmentType;

class Rapier extends UnitEquipmentType
{
    public int $weight = 1;

    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Melee;
    }

    public function technology(): ?TechnologyType
    {
        return Banking::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return FlintlockMusket::get();
    }
}
