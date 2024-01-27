<?php

namespace App\Technologies\Digital;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class SatellitePositioning extends TechnologyType
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
            Internet::get(),
            Composites::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(49, 6);
    }
}
