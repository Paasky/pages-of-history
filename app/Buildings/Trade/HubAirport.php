<?php

namespace App\Buildings\Trade;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Digital\Globalization;
use App\Technologies\TechnologyType;
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

    /**
     * @return Collection<int, YieldModifiersFor>
     */
    public function yieldModifiers(): Collection
    {
        return collect([

        ]);
    }
}
