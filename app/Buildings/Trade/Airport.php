<?php

namespace App\Buildings\Trade;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Atomic\Transistor;
use App\Technologies\TechnologyType;
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

    /**
     * @return Collection<int, YieldModifiersFor>
     */
    public function yieldModifiers(): Collection
    {
        return collect([

        ]);
    }
}
