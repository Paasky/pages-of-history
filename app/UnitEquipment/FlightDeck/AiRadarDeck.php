<?php

namespace App\UnitEquipment\FlightDeck;

use App\Enums\UnitEquipmentCategory;
use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\Technologies\Nano\NeuralNetworks;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class AiRadarDeck extends UnitEquipmentType
{
    public int $weight = 3;

    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::FlightDeck;
    }

    public function name(): string
    {
        return 'AI Radar Deck';
    }

    public function technology(): ?TechnologyType
    {
        return NeuralNetworks::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return null;
    }

    public function yieldModifiers(): Collection
    {
        return parent::yieldModifiers()->merge([
            new YieldModifier(YieldType::VisionRange, 2),
            new YieldModifiersFor(
                collect([new YieldModifier(YieldType::Cargo, 2)]),
                [UnitPlatformCategory::Air]
            ),
        ]);
    }
}