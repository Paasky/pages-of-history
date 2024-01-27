<?php

namespace App\UnitArmor\Vehicle;

use App\Enums\UnitArmorCategory;
use App\Technologies\Modern\SyntheticMaterials;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;

class HeavyArmor extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Vehicle;
    }

    public function technology(): ?TechnologyType
    {
        return SyntheticMaterials::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return CompositeArmor::get();
    }
}
