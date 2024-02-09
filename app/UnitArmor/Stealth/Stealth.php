<?php

namespace App\UnitArmor\Stealth;

use App\Enums\UnitArmorCategory;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;

class Stealth extends UnitArmorType
{
    public int $weight = 0;

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
