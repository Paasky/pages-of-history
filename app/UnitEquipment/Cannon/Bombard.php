<?php

namespace App\UnitEquipment\Cannon;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Renaissance\Gunpowder;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Bombard extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Cannon;
    }

    public function technology(): ?TechnologyType
    {
        return Gunpowder::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Cannon::get();
    }
}
