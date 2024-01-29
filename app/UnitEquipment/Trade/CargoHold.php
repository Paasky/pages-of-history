<?php

namespace App\UnitEquipment\Trade;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Enlightenment\Mercantilism;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class CargoHold extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Trade;
    }

    public function technology(): ?TechnologyType
    {
        return Mercantilism::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return ContainerHold::get();
    }
}
