<?php

namespace App\UnitEquipment\Skirmish;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Bronze\BronzeWorking;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class BronzeThrowingSpear extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Skirmish;
    }

    public function technology(): ?TechnologyType
    {
        return BronzeWorking::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return IronThrowingSpear::get();
    }
}
