<?php

namespace App\UnitEquipment\AntiAir;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Nano\ArtificialIntelligence;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class AiMissile extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::AntiAir;
    }

    public function name(): string
    {
        return 'AI Missile';
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
