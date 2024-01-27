<?php

namespace App\UnitEquipment\Diplomacy;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Bronze\Writing;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Emissary extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Diplomacy;
    }

    public function technology(): ?TechnologyType
    {
        return Writing::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Envoy::get();
    }
}
