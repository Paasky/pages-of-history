<?php

namespace App\UnitEquipment\Espionage;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Bronze\CodeOfLaw;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Thief extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Espionage;
    }

    public function technology(): ?TechnologyType
    {
        return CodeOfLaw::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Courtesan::get();
    }
}
