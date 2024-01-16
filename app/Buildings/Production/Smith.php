<?php

namespace App\Buildings\Production;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Bronze\BronzeWorking;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Smith extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Production;
    }

    public function technology(): ?TechnologyType
    {
        return BronzeWorking::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Blacksmith::get();
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
