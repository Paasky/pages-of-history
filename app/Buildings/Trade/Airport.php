<?php

namespace App\Buildings\Trade;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Enums\Domain;
use App\Enums\YieldType;
use App\Technologies\Atomic\Transistor;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Airport extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::AirTrade;
    }

    public function technology(): ?TechnologyType
    {
        return Transistor::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return HubAirport::get();
    }

    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Cost, $this->technology()->era()->baseCost()),
            new YieldModifier($this, YieldType::Gold, -6),
            new YieldModifiersFor(
                [
                    new YieldModifier($this, YieldType::Capacity, 3),
                    new YieldModifier($this, YieldType::Trade, 6),
                ],
                Domain::Air
            ),
        ]);
    }
}
