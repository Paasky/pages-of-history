<?php

namespace App\UnitArmor\Stealth;

use App\Enums\UnitArmorCategory;
use App\Technologies\Enlightenment\Mercantilism;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\UnitArmor\Vehicle\Ironclad;

class Privateer extends UnitArmorType
{
    public int $weight = 0;

    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Stealth;
    }

    public function icon(): string
    {
        return 'fa-skull-crossbones';
    }

    public function technology(): ?TechnologyType
    {
        return Mercantilism::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return Ironclad::get();
    }
}
