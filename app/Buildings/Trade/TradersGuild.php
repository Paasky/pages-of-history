<?php

namespace App\Buildings\Trade;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\HighMedieval\Guilds;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class TradersGuild extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::LandTrade;
    }

    public function technology(): ?TechnologyType
    {
        return Guilds::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Warehouse::get();
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
