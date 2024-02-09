<?php

namespace App\UnitArmor\Stealth;

use App\Enums\UnitArmorCategory;
use App\Technologies\Modern\ArtDeco;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;

class Camouflage extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Stealth;
    }

    public function icon(): string
    {
        return 'fa-tree';
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
