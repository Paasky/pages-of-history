<?php

namespace App\UnitEquipment\AntiAir;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Nano\WeaponizedLasers;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class AntiAirLaser extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::AntiAir;
    }

    public function name(): string
    {
        return 'AA Laser';
    }

    public function technology(): ?TechnologyType
    {
        return WeaponizedLasers::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return null;
    }
}
