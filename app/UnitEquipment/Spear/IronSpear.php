<?php

namespace App\UnitEquipment\Spear;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Iron\IronWorking;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class IronSpear extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Spear;
    }

    public function technology(): ?TechnologyType
    {
        return IronWorking::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Lance::get();
    }
}
