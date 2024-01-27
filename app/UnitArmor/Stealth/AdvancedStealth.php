<?php

namespace App\UnitArmor\Stealth;

use App\Enums\UnitArmorCategory;
use App\Technologies\Information\Graphene;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;

class AdvancedStealth extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Stealth;
    }

    public function technology(): ?TechnologyType
    {
        return Graphene::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return null;
    }
}
