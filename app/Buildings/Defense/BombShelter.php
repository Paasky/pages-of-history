<?php

namespace App\Buildings\Defense;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Modern\Militarism;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class BombShelter extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Defense;
    }

    public function technology(): ?TechnologyType
    {
        return Militarism::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return CivilDefense::get();
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
