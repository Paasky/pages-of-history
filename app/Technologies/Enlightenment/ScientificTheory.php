<?php

namespace App\Technologies\Enlightenment;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class ScientificTheory extends TechnologyType
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
            RoyalCharter::get(),
            Corporation::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(30, 5);
    }
}
