<?php

namespace App\UnitArmor\Person;

use App\Enums\UnitArmorCategory;
use App\Technologies\Bronze\BronzeWorking;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;

class BronzePlate extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Person;
    }

    public function technology(): ?TechnologyType
    {
        return BronzeWorking::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return IronPlate::get();
    }
}
