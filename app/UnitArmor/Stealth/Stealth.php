<?php

namespace App\UnitArmor\Stealth;

use App\UnitArmor\UnitArmorType;
use App\Enums\UnitArmorCategory;
use App\Technologies\Neolithic\WoodWorking;
use App\Technologies\TechnologyType;

class Stealth extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Stealth;
    }

    public function technology(): ?TechnologyType
    {
        return \App\Technologies\Digital\Stealth::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return AdvancedStealth::get();
    }
}
