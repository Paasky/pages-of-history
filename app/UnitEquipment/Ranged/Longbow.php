<?php

namespace App\UnitEquipment\Ranged;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\HighMedieval\MilitaryTactics;
use App\Technologies\TechnologyType;
use App\UnitEquipment\SkirmishFirearm\Arquebus;
use App\UnitEquipment\UnitEquipmentType;

class Longbow extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Ranged;
    }

    public function technology(): ?TechnologyType
    {
        return MilitaryTactics::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Arquebus::get();
    }
}
