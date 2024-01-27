<?php

namespace App\UnitArmor\Air;

use App\Enums\UnitArmorCategory;
use App\Technologies\Atomic\Telecommunications;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;

class ChaffFlare extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Air;
    }

    public function technology(): ?TechnologyType
    {
        return Telecommunications::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return RadarJamming::get();
    }
}
