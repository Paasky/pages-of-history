<?php

namespace App\UnitEquipment\Siege;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\HighMedieval\SiegeTactics;
use App\Technologies\TechnologyType;
use App\UnitEquipment\Cannon\Bombard;
use App\UnitEquipment\UnitEquipmentType;

class Trebuchet extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Siege;
    }

    public function technology(): ?TechnologyType
    {
        return SiegeTactics::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Bombard::get();
    }
}
