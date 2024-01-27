<?php

namespace App\UnitEquipment\Building;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Enlightenment\ScientificTheory;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Engineer extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Building;
    }

    public function technology(): ?TechnologyType
    {
        return ScientificTheory::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Tractor::get();
    }
}
