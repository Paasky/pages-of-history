<?php

namespace App\Buildings\Health;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Modern\Penicillin;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Pharmacy extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Health;
    }

    public function technology(): ?TechnologyType
    {
        return Penicillin::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return SewageTreatment::get();
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
