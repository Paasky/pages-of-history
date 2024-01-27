<?php

namespace App\UnitEquipment\Siege;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Bronze\Sieging;
use App\Technologies\TechnologyType;
use App\UnitEquipment\Melee\BronzeSword;
use App\UnitEquipment\UnitEquipmentType;

class Ram extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Siege;
    }

    public function technology(): ?TechnologyType
    {
        return Sieging::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Catapult::get();
    }
}
