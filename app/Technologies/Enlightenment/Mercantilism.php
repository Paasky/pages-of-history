<?php

namespace App\Technologies\Enlightenment;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Renaissance\Astronomy;
use App\Technologies\Renaissance\Colonization;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Mercantilism extends TechnologyType
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
            Colonization::get(),
            Astronomy::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(27, 2);
    }
}
