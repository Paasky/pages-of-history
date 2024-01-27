<?php

namespace App\UnitEquipment\Trade;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Digital\Globalization;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Container extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Trade;
    }

    public function technology(): ?TechnologyType
    {
        return Globalization::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return null;
    }
}
