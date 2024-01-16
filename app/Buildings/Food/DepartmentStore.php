<?php

namespace App\Buildings\Food;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Gilded\Electricity;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class DepartmentStore extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Food;
    }

    public function technology(): ?TechnologyType
    {
        return Electricity::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Supermarket::get();
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
