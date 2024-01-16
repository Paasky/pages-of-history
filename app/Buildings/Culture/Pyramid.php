<?php

namespace App\Buildings\Culture;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Bronze\Masonry;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Pyramid extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Culture;
    }

    public function technology(): ?TechnologyType
    {
        return Masonry::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Amphitheater::get();
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
