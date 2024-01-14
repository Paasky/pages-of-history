<?php

namespace App\Technologies\Atomic;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Modern\JetEngine;
use App\Technologies\Modern\SyntheticMaterials;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Plastics extends TechnologyType
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
            SyntheticMaterials::get(),
            JetEngine::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(43, 6);
    }
}
