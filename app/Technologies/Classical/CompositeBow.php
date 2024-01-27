<?php

namespace App\Technologies\Classical;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class CompositeBow extends TechnologyType
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
            DramaAndPoetry::get(),
            Philosophy::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(13, 4);
    }
}
