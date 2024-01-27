<?php

namespace App\UnitArmor\Person;

use App\Enums\UnitArmorCategory;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;

class Chainmail extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Person;
    }

    public function technology(): ?TechnologyType
    {
        return \App\Technologies\Medieval\Chainmail::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return SteelPlate::get();
    }
}
