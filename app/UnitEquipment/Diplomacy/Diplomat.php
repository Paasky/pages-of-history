<?php

namespace App\UnitEquipment\Diplomacy;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Enlightenment\Diplomacy;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Diplomat extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Diplomacy;
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
