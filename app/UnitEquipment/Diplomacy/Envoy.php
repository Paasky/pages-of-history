<?php

namespace App\UnitEquipment\Diplomacy;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\HighMedieval\Chivalry;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Envoy extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Diplomacy;
    }

    public function technology(): ?TechnologyType
    {
        return Chivalry::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Diplomat::get();
    }
}
