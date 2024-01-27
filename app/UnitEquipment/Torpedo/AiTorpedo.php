<?php

namespace App\UnitEquipment\Torpedo;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Nano\ArtificialIntelligence;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class AiTorpedo extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Torpedo;
    }

    public function technology(): ?TechnologyType
    {
        return ArtificialIntelligence::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return null;
    }
}
