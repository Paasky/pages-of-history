<?php

namespace App\Technologies\Renaissance;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Perspective extends TechnologyType
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
            Banking::get(),
            Gunpowder::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(24, 5);
    }
}
