<?php

namespace App\Technologies\Gilded;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class SmokelessPowder extends TechnologyType
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
            Sanitization::get(),
            SteelMilling::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(36, 3);
    }
}
