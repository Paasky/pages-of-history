<?php

namespace App\UnitEquipment\Expansion;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Renaissance\Colonization;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Colonist extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Expansion;
    }

    public function technology(): ?TechnologyType
    {
        return Colonization::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Pioneer::get();
    }
}
