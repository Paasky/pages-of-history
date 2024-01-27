<?php

namespace App\UnitEquipment\Melee;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Iron\IronWorking;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class IronSword extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Melee;
    }

    public function technology(): ?TechnologyType
    {
        return IronWorking::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return SteelSword::get();
    }
}
