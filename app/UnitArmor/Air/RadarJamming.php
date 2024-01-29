<?php

namespace App\UnitArmor\Air;

use App\Enums\UnitArmorCategory;
use App\Technologies\Digital\ParticlePhysics;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;

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
