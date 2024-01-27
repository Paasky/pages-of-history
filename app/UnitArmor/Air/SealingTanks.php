<?php

namespace App\UnitArmor\Air;

use App\UnitArmor\UnitArmorType;
use App\Enums\UnitArmorCategory;
use App\Technologies\Modern\MetalAlloys;
use App\Technologies\Neolithic\WoodWorking;
use App\Technologies\TechnologyType;

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
