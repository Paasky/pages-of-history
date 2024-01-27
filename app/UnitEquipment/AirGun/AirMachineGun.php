<?php

namespace App\UnitEquipment\AirGun;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Gilded\Flight;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class AirMachineGun extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::AirGun;
    }

    public function technology(): ?TechnologyType
    {
        return Flight::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return AirHomingMissile::get();
    }
}
