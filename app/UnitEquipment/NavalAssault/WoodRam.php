<?php

namespace App\UnitEquipment\NavalAssault;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Neolithic\WoodWorking;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class WoodRam extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::NavalAssault;
    }

    public function technology(): ?TechnologyType
    {
        return WoodWorking::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return BronzeRam::get();
    }
}
