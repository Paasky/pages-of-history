<?php

namespace App\Buildings\Training;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Modern\Radar;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Airfield extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::AirTraining;
    }

    public function technology(): ?TechnologyType
    {
        return Radar::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return AirBase::get();
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
