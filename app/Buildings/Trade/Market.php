<?php

namespace App\Buildings\Trade;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Bronze\Currency;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Market extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::LandTrade;
    }

    public function technology(): ?TechnologyType
    {
        return Currency::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return TradersGuild::get();
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
