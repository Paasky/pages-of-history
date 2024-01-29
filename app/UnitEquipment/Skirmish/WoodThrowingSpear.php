<?php

namespace App\UnitEquipment\Skirmish;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Neolithic\WoodWorking;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class WoodThrowingSpear extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Skirmish;
    }

    public function technology(): ?TechnologyType
    {
        return WoodWorking::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return BronzeThrowingSpear::get();
    }
}
