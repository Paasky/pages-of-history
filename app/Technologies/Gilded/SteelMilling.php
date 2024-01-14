<?php

namespace App\Technologies\Gilded;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Industrial\Fertilizer;
use App\Technologies\Industrial\Nitroglycerin;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class SteelMilling extends TechnologyType
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
            Nitroglycerin::get(),
            Fertilizer::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(35, 4);
    }
}
