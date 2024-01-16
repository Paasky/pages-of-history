<?php

namespace App\Buildings\Training;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Classical\CompositeBow;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class ArcheryRange extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::LandTraining;
    }

    public function technology(): ?TechnologyType
    {
        return CompositeBow::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Barracks::get();
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
