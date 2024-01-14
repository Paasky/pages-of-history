<?php

namespace App\Technologies\Gilded;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Industrial\Telegraph;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class HauteCouture extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Gilded;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            Telegraph::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(35, 7);
    }
}
