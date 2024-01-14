<?php

namespace App\Technologies\Industrial;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Enlightenment\Diplomacy;
use App\Technologies\Enlightenment\ScientificTheory;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Vaccines extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Industrial;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            ScientificTheory::get(),
            Diplomacy::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(31, 6);
    }
}
