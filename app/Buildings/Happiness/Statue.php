<?php

namespace App\Buildings\Happiness;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Enums\YieldType;
use App\Technologies\Bronze\Artisanship;
use App\Technologies\Bronze\BronzeWorking;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Statue extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Happiness;
    }

    public function technology(): ?TechnologyType
    {
        return BronzeWorking::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Arena::get();
    }

    /**
     * @return Collection<int, YieldModifiersFor>
     */
    public function yieldModifiersFors(): Collection
    {
        return collect([

        ]);
    }
}
