<?php

namespace App\Technologies\Classical;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Iron\Bureaucracy;
use App\Technologies\Iron\ShipBuilding;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Engineering extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Classical;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            Bureaucracy::get(),
            ShipBuilding::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(12, 7);
    }
}
