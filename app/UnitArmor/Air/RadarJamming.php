<?php

namespace App\UnitArmor\Air;

use App\UnitArmor\UnitArmorType;
use App\Enums\UnitArmorCategory;
use App\Technologies\Digital\ParticlePhysics;
use App\Technologies\Neolithic\WoodWorking;
use App\Technologies\TechnologyType;

class RadarJamming extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Air;
    }

    public function technology(): ?TechnologyType
    {
        return ParticlePhysics::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return null;
    }
}
