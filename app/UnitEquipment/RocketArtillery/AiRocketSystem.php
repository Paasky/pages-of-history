<?php

namespace App\UnitEquipment\RocketArtillery;

use App\Enums\UnitEquipmentCategory;
use App\Technologies\Nano\NeuralNetworks;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;

class AiRocketSystem extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::RocketArtillery;
    }

    public function name(): string
    {
        return 'AI Rocket System';
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
