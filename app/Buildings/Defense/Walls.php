<?php

namespace App\Buildings\Defense;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Enums\YieldType;
use App\Technologies\Bronze\Sieging;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Walls extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Defense;
    }

    public function technology(): ?TechnologyType
    {
        return Sieging::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Garrison::get();
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
