<?php

namespace App\Technologies\Copper;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Archery extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Copper;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            CopperWorking::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(4, 3);
    }
}
