<?php

namespace App\UnitArmor\Air;

use App\Enums\UnitArmorCategory;
use App\Technologies\Modern\MetalAlloys;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;

class SealingTanks extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Air;
    }

    public function technology(): ?TechnologyType
    {
        return MetalAlloys::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return ChaffFlare::get();
    }
}
