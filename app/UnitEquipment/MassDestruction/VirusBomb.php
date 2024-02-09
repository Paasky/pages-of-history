<?php

namespace App\UnitEquipment\MassDestruction;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Digital\Genetics;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class VirusBomb extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::MassDestruction;
    }

    public function icon(): string
    {
        return 'fa-biohazard';
    }

    public function technology(): ?TechnologyType
    {
        return Genetics::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return null;
    }
}
