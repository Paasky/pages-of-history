<?php

namespace App\UnitArmor\Person;

use App\Enums\UnitArmorCategory;
use App\Technologies\Iron\IronWorking;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;

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
