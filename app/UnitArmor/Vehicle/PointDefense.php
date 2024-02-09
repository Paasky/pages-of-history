<?php

namespace App\UnitArmor\Vehicle;

use App\Enums\UnitArmorCategory;
use App\Technologies\Nano\Nanobots;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;

class PointDefense extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Vehicle;
    }

    public function technology(): ?TechnologyType
    {
        return Nanobots::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return null;
    }
}
