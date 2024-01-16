<?php

namespace App\Buildings\Culture;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Digital\Internet;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class InternetProvider extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Culture;
    }

    public function technology(): ?TechnologyType
    {
        return Internet::get();
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
