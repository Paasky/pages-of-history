<?php

namespace App\Technologies\Renaissance;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class SquareRigging extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Renaissance;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            MilitaryEngineering::get(),
            Architecture::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(25, 2);
    }
}
