<?php

namespace App\UnitArmor\Person;

use App\Enums\UnitArmorCategory;
use App\Technologies\HighMedieval\Steel;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;

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
