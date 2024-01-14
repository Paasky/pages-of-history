<?php

namespace App\Technologies\Classical;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Iron\Sports;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class MilitaryDiscipline extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Classical;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            Sports::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(12, 1);
    }
}
