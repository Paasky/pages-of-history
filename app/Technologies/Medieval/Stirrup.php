<?php

namespace App\Technologies\Medieval;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Classical\ProfessionalArmy;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Stirrup extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Medieval;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            ProfessionalArmy::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(15, 2);
    }
}
