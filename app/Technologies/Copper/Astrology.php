<?php

namespace App\Technologies\Copper;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Neolithic\Mysticism;
use App\Technologies\Neolithic\Pottery;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Astrology extends TechnologyType
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
            Pottery::get(),
            Mysticism::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(3, 6);
    }
}
