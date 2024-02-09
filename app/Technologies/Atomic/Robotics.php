<?php

namespace App\Technologies\Atomic;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Robotics extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Atomic;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            Satellites::get(),
            Telecommunications::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(46, 6);
    }
}
