<?php

namespace App\Buildings\Defense;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\HighMedieval\SiegeTactics;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class SiegeWalls extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Defense;
    }

    public function technology(): ?TechnologyType
    {
        return SiegeTactics::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Trenches::get();
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
