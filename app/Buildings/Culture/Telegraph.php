<?php

namespace App\Buildings\Culture;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Telegraph extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Culture;
    }

    public function technology(): ?TechnologyType
    {
        return \App\Technologies\Industrial\Telegraph::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return ArtGallery::get();
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
