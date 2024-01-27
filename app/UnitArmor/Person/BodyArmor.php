<?php

namespace App\UnitArmor\Person;

use App\Enums\UnitArmorCategory;
use App\Technologies\Digital\Composites;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;

class BodyArmor extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Person;
    }

    public function technology(): ?TechnologyType
    {
        return Composites::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return null;
    }
}
