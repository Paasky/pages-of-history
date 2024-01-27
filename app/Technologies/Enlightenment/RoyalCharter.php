<?php

namespace App\Technologies\Enlightenment;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class RoyalCharter extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Enlightenment;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            Navigation::get(),
            Metallurgy::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(29, 4);
    }
}
