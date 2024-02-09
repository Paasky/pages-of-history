<?php

namespace App\UnitEquipment\NavalAssault;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Enlightenment\Chemistry;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Buccaneers extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::NavalAssault;
    }

    public function technology(): ?TechnologyType
    {
        return Chemistry::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return MusketMarines::get();
    }
}
