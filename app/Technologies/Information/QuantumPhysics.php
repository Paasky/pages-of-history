<?php

namespace App\Technologies\Information;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Digital\Biotech;
use App\Technologies\Digital\ParticlePhysics;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class QuantumPhysics extends TechnologyType
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
            Biotech::get(),
            ParticlePhysics::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(51, 2);
    }
}
