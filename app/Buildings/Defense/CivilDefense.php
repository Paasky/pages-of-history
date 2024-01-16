<?php

namespace App\Buildings\Defense;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Atomic\NuclearFission;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class CivilDefense extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Defense;
    }

    public function technology(): ?TechnologyType
    {
        return NuclearFission::get();
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
