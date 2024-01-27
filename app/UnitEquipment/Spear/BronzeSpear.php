<?php

namespace App\UnitEquipment\Spear;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Bronze\BronzeWorking;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class BronzeSpear extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Spear;
    }

    public function technology(): ?TechnologyType
    {
        return BronzeWorking::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return IronSpear::get();
    }
}
