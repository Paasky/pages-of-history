<?php

namespace App\UnitEquipment\NavalAssault;

use App\Enums\UnitEquipmentCategory;
use App\Resources\Strategic\Iron;
use App\Technologies\Iron\Construction;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;
use Illuminate\Support\Collection;

class IronRam extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::NavalAssault;
    }

    public function requires(): Collection
    {
        return parent::requires()->add(Iron::get());
    }

    public function technology(): ?TechnologyType
    {
        return Construction::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return SteelRam::get();
    }
}
