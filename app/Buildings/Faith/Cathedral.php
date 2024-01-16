<?php

namespace App\Buildings\Faith;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Renaissance\Architecture;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Cathedral extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Faith;
    }

    public function technology(): ?TechnologyType
    {
        return Architecture::get();
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
