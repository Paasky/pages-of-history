<?php

namespace App\Buildings\Health;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Gilded\Sanitization;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Sewer extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Health;
    }

    public function technology(): ?TechnologyType
    {
        return Sanitization::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Pharmacy::get();
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
