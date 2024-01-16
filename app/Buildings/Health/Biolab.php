<?php

namespace App\Buildings\Health;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Digital\Biotech;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Biolab extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Health;
    }

    public function technology(): ?TechnologyType
    {
        return Biotech::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return VaccinePlant::get();
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
