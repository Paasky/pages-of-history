<?php

namespace App\Buildings\Culture;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Enums\YieldType;
use App\Technologies\Atomic\Telecommunications;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class TvTower extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Culture;
    }

    public function technology(): ?TechnologyType
    {
        return Telecommunications::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return InternetProvider::get();
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
