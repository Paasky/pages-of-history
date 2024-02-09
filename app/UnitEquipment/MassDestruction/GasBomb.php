<?php

namespace App\UnitEquipment\MassDestruction;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Modern\Penicillin;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class GasBomb extends UnitEquipmentType
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
        return Penicillin::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return VirusBomb::get();
    }
}
