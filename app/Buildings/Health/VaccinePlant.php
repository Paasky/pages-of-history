<?php

namespace App\Buildings\Health;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Enums\YieldType;
use App\Technologies\Atomic\Ecology;
use App\Technologies\Digital\Biotech;
use App\Technologies\Information\MrnaVaccines;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class VaccinePlant extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Health;
    }

    public function technology(): ?TechnologyType
    {
        return MrnaVaccines::get();
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
