<?php

namespace App\UnitEquipment\Skirmish;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\HighMedieval\Machinery;
use App\Technologies\TechnologyType;
use App\UnitEquipment\SkirmishFirearm\Arquebus;
use App\UnitEquipment\UnitEquipmentType;

class Crossbow extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Skirmish;
    }

    public function technology(): ?TechnologyType
    {
        return Machinery::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Arquebus::get();
    }
}
