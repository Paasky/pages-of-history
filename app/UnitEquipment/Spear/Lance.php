<?php

namespace App\UnitEquipment\Spear;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Medieval\Stirrup;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Lance extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Spear;
    }

    public function technology(): ?TechnologyType
    {
        return Stirrup::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Halberd::get();
    }
}
