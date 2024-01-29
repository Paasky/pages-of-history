<?php

namespace App\UnitArmor\Vehicle;

use App\Enums\UnitArmorCategory;
use App\Technologies\Classical\Engineering;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;

class Multideck extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Vehicle;
    }

    public function technology(): ?TechnologyType
    {
        return Engineering::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return Ironclad::get();
    }
}
