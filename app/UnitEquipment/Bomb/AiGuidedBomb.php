<?php

namespace App\UnitEquipment\Bomb;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Nano\ArtificialIntelligence;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class AiGuidedBomb extends UnitEquipmentType
{
    public int $weight = 1;

    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::AirBomb;
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
