<?php

namespace App\UnitArmor\Vehicle;

use App\Enums\UnitArmorCategory;
use App\Technologies\Industrial\Industrialization;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;

class Ironclad extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Vehicle;
    }

    public function technology(): ?TechnologyType
    {
        return Industrialization::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return SteelArmor::get();
    }
}
