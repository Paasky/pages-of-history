<?php

namespace App\Technologies\Digital;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Atomic\Environmentalism;
use App\Technologies\Atomic\Robotics;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Microchips extends TechnologyType
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
            Robotics::get(),
            Environmentalism::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(47, 6);
    }
}
