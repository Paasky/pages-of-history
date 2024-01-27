<?php

namespace App\UnitEquipment\Cannon;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Enlightenment\Metallurgy;
use App\Technologies\TechnologyType;
use App\UnitEquipment\Artillery\Artillery;
use App\UnitEquipment\UnitEquipmentType;

class Cannon extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Cannon;
    }

    public function technology(): ?TechnologyType
    {
        return Metallurgy::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Artillery::get();
    }
}
