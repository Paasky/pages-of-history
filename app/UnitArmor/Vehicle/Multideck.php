<?php

namespace App\UnitArmor\Vehicle;

use App\UnitArmor\UnitArmorType;
use App\Enums\UnitArmorCategory;
use App\Technologies\Classical\Engineering;
use App\Technologies\Neolithic\WoodWorking;
use App\Technologies\TechnologyType;

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
