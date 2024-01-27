<?php

namespace App\UnitArmor\Vehicle;

use App\Enums\UnitArmorCategory;
use App\Technologies\Information\Graphene;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;

class ActiveDefense extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Vehicle;
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
