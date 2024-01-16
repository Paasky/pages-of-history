<?php

namespace App\Buildings\Defense;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Gilded\SmokelessPowder;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Trenches extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Defense;
    }

    public function technology(): ?TechnologyType
    {
        return SmokelessPowder::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return BombShelter::get();
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
