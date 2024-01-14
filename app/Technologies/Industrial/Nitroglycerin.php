<?php

namespace App\Technologies\Industrial;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Nitroglycerin extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Industrial;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            CoalGasification::get(),
            Railroad::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(34, 3);
    }
}
