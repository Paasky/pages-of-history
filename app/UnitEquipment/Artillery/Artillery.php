<?php

namespace App\UnitEquipment\Artillery;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Gilded\Dynamite;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Artillery extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Artillery;
    }

    public function technology(): ?TechnologyType
    {
        return Dynamite::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Howitzer::get();
    }
}
