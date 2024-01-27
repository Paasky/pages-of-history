<?php

namespace App\Technologies\Bronze;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Copper\Government;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Calendar extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Bronze;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            Government::get()
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(5, 8);
    }
}
