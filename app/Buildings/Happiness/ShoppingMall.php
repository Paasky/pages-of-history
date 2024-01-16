<?php

namespace App\Buildings\Happiness;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Atomic\Macroeconomics;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class ShoppingMall extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Happiness;
    }

    public function technology(): ?TechnologyType
    {
        return Macroeconomics::get();
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
