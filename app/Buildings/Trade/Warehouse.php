<?php

namespace App\Buildings\Trade;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Enlightenment\RoyalCharter;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Warehouse extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::LandTrade;
    }

    public function technology(): ?TechnologyType
    {
        return RoyalCharter::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return CentralStation::get();
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
