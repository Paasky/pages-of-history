<?php

namespace App\UnitEquipment\NavalAssault;

use App\Enums\UnitEquipmentCategory;
use App\Resources\Processed\Steel;
use App\Technologies\HighMedieval\Compass;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;
use Illuminate\Support\Collection;

class SteelRam extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::NavalAssault;
    }

    public function requires(): Collection
    {
        return parent::requires()->add(Steel::get());
    }

    public function technology(): ?TechnologyType
    {
        return Compass::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return RaidingParty::get();
    }
}
