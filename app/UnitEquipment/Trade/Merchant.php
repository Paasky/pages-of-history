<?php

namespace App\UnitEquipment\Trade;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Medieval\Paper;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Merchant extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Trade;
    }

    public function technology(): ?TechnologyType
    {
        return Paper::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return CargoHold::get();
    }
}
