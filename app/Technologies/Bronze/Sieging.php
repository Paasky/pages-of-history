<?php

namespace App\Technologies\Bronze;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Sieging extends TechnologyType
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
            Wheel::get(),
            Masonry::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(7, 4);
    }
}
