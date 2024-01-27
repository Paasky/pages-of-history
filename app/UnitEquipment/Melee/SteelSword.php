<?php

namespace App\UnitEquipment\Melee;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\HighMedieval\Steel;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class SteelSword extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Melee;
    }

    public function technology(): ?TechnologyType
    {
        return Steel::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Rapier::get();
    }
}
