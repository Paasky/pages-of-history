<?php

namespace App\UnitArmor\Person;

use App\UnitArmor\UnitArmorType;
use App\Enums\UnitArmorCategory;
use App\Technologies\HighMedieval\Steel;
use App\Technologies\Neolithic\WoodWorking;
use App\Technologies\TechnologyType;

class SteelPlate extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Person;
    }

    public function technology(): ?TechnologyType
    {
        return Steel::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return BodyArmor::get();
    }
}
