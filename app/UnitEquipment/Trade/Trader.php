<?php

namespace App\UnitEquipment\Trade;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Bronze\Calendar;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Trader extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Trade;
    }

    public function technology(): ?TechnologyType
    {
        return Calendar::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Merchant::get();
    }
}
