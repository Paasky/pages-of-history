<?php

namespace App\Technologies\Information;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class AutonomousRobotics extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Information;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            MrnaVaccines::get(),
            PrivateSpaceFlight::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(54, 3);
    }
}
