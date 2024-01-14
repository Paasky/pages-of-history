<?php

namespace App\Technologies\Industrial;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Enlightenment\Constitution;
use App\Technologies\Enlightenment\ScientificTheory;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class SteamPower extends TechnologyType
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
            Constitution::get(),
            ScientificTheory::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(31, 4);
    }
}
