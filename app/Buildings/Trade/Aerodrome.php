<?php

namespace App\Buildings\Trade;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Enums\Domain;
use App\Enums\YieldType;
use App\Technologies\Gilded\Flight;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Aerodrome extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::AirTrade;
    }

    public function technology(): ?TechnologyType
    {
        return Flight::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Airport::get();
    }

    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Cost, $this->technology()->era()->baseCost()),
            new YieldModifier($this, YieldType::Gold, -4),
            new YieldModifiersFor(
                [
                    new YieldModifier($this, YieldType::Capacity, 2),
                    new YieldModifier($this, YieldType::Trade, 4),
                ],
                Domain::Air
            ),
        ]);
    }
}
