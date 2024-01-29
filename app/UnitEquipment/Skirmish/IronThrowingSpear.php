<?php

namespace App\UnitEquipment\Skirmish;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Iron\IronWorking;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class IronThrowingSpear extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Skirmish;
    }

    public function technology(): ?TechnologyType
    {
        return IronWorking::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Crossbow::get();
    }
}
