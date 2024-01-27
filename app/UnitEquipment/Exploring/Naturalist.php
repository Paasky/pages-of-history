<?php

namespace App\UnitEquipment\Exploring;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Enlightenment\Liberalism;
use App\Technologies\Industrial\Archeology;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class Naturalist extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Exploring;
    }

    public function technology(): ?TechnologyType
    {
        return Liberalism::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Archeologist::get();
    }
}
