<?php

namespace App\UnitArmor\Vehicle;

use App\Enums\UnitArmorCategory;
use App\Technologies\Digital\Composites;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;

class CompositeArmor extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Vehicle;
    }

    public function technology(): ?TechnologyType
    {
        return Composites::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return PointDefense::get();
    }
}
