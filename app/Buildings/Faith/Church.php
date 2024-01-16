<?php

namespace App\Buildings\Faith;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Medieval\StateReligion;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Church extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Faith;
    }

    public function technology(): ?TechnologyType
    {
        return StateReligion::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Monastery::get();
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
