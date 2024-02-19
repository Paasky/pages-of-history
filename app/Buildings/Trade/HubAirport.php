<?php

namespace App\Buildings\Trade;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Enums\Domain;
use App\Enums\YieldType;
use App\Technologies\Digital\Globalization;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class HubAirport extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::AirTrade;
    }

    public function technology(): ?TechnologyType
    {
        return Globalization::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return null;
    }

    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Cost, $this->technology()->era()->baseCost()),
            new YieldModifier($this, YieldType::Gold, -8),
            new YieldModifiersFor(
                [
                    new YieldModifier($this, YieldType::Capacity, 4),
                    new YieldModifier($this, YieldType::Trade, 8),
                ],
                Domain::Air
            ),
        ]);
    }
}
