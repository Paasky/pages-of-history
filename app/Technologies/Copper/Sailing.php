<?php

namespace App\Technologies\Copper;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Neolithic\Fishing;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Sailing extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Copper;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            Fishing::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(3, 9);
    }
}
