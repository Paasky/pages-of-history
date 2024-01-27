<?php

namespace App\UnitArmor\Vehicle;

use App\UnitArmor\UnitArmorType;
use App\Enums\UnitArmorCategory;
use App\Technologies\Gilded\StainlessSteel;
use App\Technologies\Neolithic\WoodWorking;
use App\Technologies\TechnologyType;

class SteelArmor extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Vehicle;
    }

    public function technology(): ?TechnologyType
    {
        return StainlessSteel::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return HeavyArmor::get();
    }
}
