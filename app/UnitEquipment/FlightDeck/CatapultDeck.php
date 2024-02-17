<?php

namespace App\UnitEquipment\FlightDeck;

use App\Enums\UnitEquipmentCategory;
use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\Technologies\Modern\JetEngine;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class CatapultDeck extends UnitEquipmentType
{
    public int $weight = 3;

    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::FlightDeck;
    }

    public function technology(): ?TechnologyType
    {
        return JetEngine::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return RadarDeck::get();
    }

    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifiersFor(
                collect([new YieldModifier($this, YieldType::Capacity, 2)]),
                [UnitPlatformCategory::Air]
            ),
        ]);
    }
}
