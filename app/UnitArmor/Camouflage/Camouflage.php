<?php

namespace App\UnitArmor\Camouflage;

use App\Enums\UnitArmorCategory;
use App\Technologies\Modern\ArtDeco;
use App\Technologies\TechnologyType;
use App\UnitArmor\Stealth\Stealth;
use App\UnitArmor\UnitArmorType;

class Camouflage extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Camouflage;
    }

    public function technology(): ?TechnologyType
    {
        return ArtDeco::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return Stealth::get();
    }
}
