<?php

namespace App\Technologies\Digital;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class FiberOptics extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Digital;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            Globalization::get(),
            SatellitePositioning::get(),
            Stealth::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(50, 5);
    }
}
