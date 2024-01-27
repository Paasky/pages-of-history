<?php

namespace App\UnitArmor\Person;

use App\UnitArmor\UnitArmorType;
use App\Enums\UnitArmorCategory;
use App\Technologies\Iron\IronWorking;
use App\Technologies\Neolithic\WoodWorking;
use App\Technologies\TechnologyType;

class IronPlate extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Person;
    }

    public function technology(): ?TechnologyType
    {
        return IronWorking::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return Chainmail::get();
    }
}
