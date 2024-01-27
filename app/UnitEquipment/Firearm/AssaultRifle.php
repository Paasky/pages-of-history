<?php

namespace App\UnitEquipment\Firearm;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Modern\CombinedArms;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class AssaultRifle extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Firearm;
    }

    public function technology(): ?TechnologyType
    {
        return CombinedArms::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return ScopeRifle::get();
    }
}
