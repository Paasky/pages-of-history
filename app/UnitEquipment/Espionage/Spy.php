<?php

namespace App\UnitEquipment\Espionage;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Enlightenment\Diplomacy;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Spy extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Espionage;
    }

    public function technology(): ?TechnologyType
    {
        return Diplomacy::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return null;
    }
}
