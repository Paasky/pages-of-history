<?php

namespace App\UnitEquipment\Exploring;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Industrial\Archeology;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Archeologist extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Exploring;
    }

    public function technology(): ?TechnologyType
    {
        return Archeology::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return null;
    }
}
