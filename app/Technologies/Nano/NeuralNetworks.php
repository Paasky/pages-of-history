<?php

namespace App\Technologies\Nano;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class NeuralNetworks extends TechnologyType
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
            ArtificialIntelligence::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(56, 7);
    }
}
