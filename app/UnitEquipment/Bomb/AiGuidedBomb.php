<?php

namespace App\UnitEquipment\Bomb;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Nano\ArtificialIntelligence;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class AiGuidedBomb extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Bomb;
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
