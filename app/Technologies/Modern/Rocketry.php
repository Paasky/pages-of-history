<?php

namespace App\Technologies\Modern;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Rocketry extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Modern;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            Electronics::get(),
            HydroEngineering::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(41, 5);
    }
}
