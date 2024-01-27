<?php

namespace App\UnitEquipment\Melee;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Bronze\BronzeWorking;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class BronzeSword extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Melee;
    }

    public function technology(): ?TechnologyType
    {
        return BronzeWorking::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return IronSword::get();
    }
}
