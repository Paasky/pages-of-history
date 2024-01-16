<?php

namespace App\Buildings\Training;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Iron\ShipBuilding;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Boatyard extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::SeaTraining;
    }

    public function technology(): ?TechnologyType
    {
        return ShipBuilding::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Drydock::get();
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
