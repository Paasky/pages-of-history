<?php

namespace App\Technologies\Bronze;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Copper\Government;
use App\Technologies\Copper\Mining;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class BronzeWorking extends TechnologyType
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
            Mining::get(),
            Government::get()
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(5, 6);
    }
}
