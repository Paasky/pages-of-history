<?php

namespace App\UnitEquipment\SkirmishFirearm;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Nano\NeuralNetworks;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class AiGuidedMortar extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::SkirmishFirearm;
    }

    public function name(): string
    {
        return 'AI Guided Mortar';
    }

    public function technology(): ?TechnologyType
    {
        return NeuralNetworks::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return null;
    }
}
