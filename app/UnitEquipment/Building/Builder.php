<?php

namespace App\UnitEquipment\Building;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Iron\Construction;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Builder extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Building;
    }

    public function technology(): ?TechnologyType
    {
        return Construction::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Peasant::get();
    }
}
