<?php

namespace App\Technologies\Digital;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Atomic\GuidanceSystems;
use App\Technologies\Atomic\Robotics;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Lasers extends TechnologyType
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
            GuidanceSystems::get(),
            Robotics::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(47, 4);
    }
}
