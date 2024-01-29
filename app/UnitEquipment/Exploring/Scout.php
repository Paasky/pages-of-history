<?php

namespace App\UnitEquipment\Exploring;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Neolithic\Domestication;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Scout extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Exploring;
    }

    public function technology(): ?TechnologyType
    {
        return Domestication::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Explorer::get();
    }
}
