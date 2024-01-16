<?php

namespace App\Buildings\Faith;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Classical\Philosophy;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class PriestsSchool extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Faith;
    }

    public function technology(): ?TechnologyType
    {
        return Philosophy::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Church::get();
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
