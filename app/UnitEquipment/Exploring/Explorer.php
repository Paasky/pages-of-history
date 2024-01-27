<?php

namespace App\UnitEquipment\Exploring;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Renaissance\Cartography;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Explorer extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Exploring;
    }

    public function technology(): ?TechnologyType
    {
        return Cartography::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Naturalist::get();
    }
}
