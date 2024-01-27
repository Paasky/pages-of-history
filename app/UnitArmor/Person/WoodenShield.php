<?php

namespace App\UnitArmor\Person;

use App\UnitArmor\UnitArmorType;
use App\Enums\UnitArmorCategory;
use App\Technologies\Neolithic\WoodWorking;
use App\Technologies\TechnologyType;

class WoodenShield extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Person;
    }

    public function technology(): ?TechnologyType
    {
        return WoodWorking::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return BronzePlate::get();
    }
}
