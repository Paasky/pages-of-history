<?php

namespace App\UnitEquipment\Spear;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Renaissance\MassProduction;
use App\Technologies\TechnologyType;
use App\UnitEquipment\Melee\BronzeSword;
use App\UnitEquipment\UnitEquipmentType;

class Pike extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Spear;
    }

    public function technology(): ?TechnologyType
    {
        return MassProduction::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Grenadier::get();
    }
}
