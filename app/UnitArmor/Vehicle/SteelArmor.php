<?php

namespace App\UnitArmor\Vehicle;

use App\Enums\UnitArmorCategory;
use App\Technologies\Gilded\StainlessSteel;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;

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
