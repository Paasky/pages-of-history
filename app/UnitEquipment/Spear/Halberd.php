<?php

namespace App\UnitEquipment\Spear;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\HighMedieval\Steel;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Halberd extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Spear;
    }

    public function technology(): ?TechnologyType
    {
        return Steel::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Pike::get();
    }
}
