<?php

namespace App\Technologies\Classical;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Iron\MarbleSculpting;
use App\Technologies\Iron\Sports;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class DramaAndPoetry extends TechnologyType
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
            MarbleSculpting::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(12, 3);
    }
}
