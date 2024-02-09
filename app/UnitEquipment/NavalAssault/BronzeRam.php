<?php

namespace App\UnitEquipment\NavalAssault;

use App\Enums\UnitEquipmentCategory;
use App\Resources\Processed\Bronze;
use App\Technologies\Bronze\CelestialNavigation;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;
use Illuminate\Support\Collection;

class BronzeRam extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::NavalAssault;
    }

    public function requires(): Collection
    {
        return parent::requires()->add(Bronze::get());
    }

    public function technology(): ?TechnologyType
    {
        return CelestialNavigation::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return IronRam::get();
    }
}
