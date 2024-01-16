<?php

namespace App\Buildings\Culture;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Theater extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Culture;
    }

    public function technology(): ?TechnologyType
    {
        return \App\Technologies\Enlightenment\Theater::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Telegraph::get();
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
