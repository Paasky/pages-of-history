<?php

namespace App\UnitEquipment\NavalAssault;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Renaissance\Gunpowder;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class RaidingParty extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::NavalAssault;
    }

    public function technology(): ?TechnologyType
    {
        return Gunpowder::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Buccaneers::get();
    }
}
