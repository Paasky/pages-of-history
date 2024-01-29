<?php

namespace App\UnitArmor;

use App\Enums\UnitArmorCategory;
use App\Technologies\TechnologyType;

class NoArmor extends UnitArmorType
{
    public int $weight = 0;

    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::None;
    }

    public function technology(): ?TechnologyType
    {
        return null;
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return null;
    }
}
