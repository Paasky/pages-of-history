<?php

namespace App\Technologies\Nano;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Information\AutonomousRobotics;
use App\Technologies\Information\QuantumComputing;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class NuclearFusion extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Nano;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            AutonomousRobotics::get(),
            QuantumComputing::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(55, 4);
    }
}
