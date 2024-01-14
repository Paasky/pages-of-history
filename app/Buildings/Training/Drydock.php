<?php

namespace App\Buildings\Training;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Enums\YieldType;
use App\Technologies\Renaissance\SquareRigging;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Drydock extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::SeaTraining;
    }

    public function technology(): ?TechnologyType
    {
        return SquareRigging::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Shipyard::get();
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
