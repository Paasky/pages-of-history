<?php

namespace App\Buildings\Trade;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Gilded\Flight;
use App\Technologies\TechnologyType;
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

    /**
     * @return Collection<int, YieldModifiersFor>
     */
    public function yieldModifiers(): Collection
    {
        return collect([

        ]);
    }
}
