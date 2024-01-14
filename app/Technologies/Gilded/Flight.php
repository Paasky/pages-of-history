<?php

namespace App\Technologies\Gilded;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Flight extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Gilded;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            Combustion::get(),
            Radio::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(38, 8);
    }
}
