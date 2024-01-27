<?php

namespace App\Technologies\Enlightenment;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Diplomacy extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Enlightenment;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            Corporation::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(30, 7);
    }
}
