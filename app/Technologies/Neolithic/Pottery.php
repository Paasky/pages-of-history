<?php

namespace App\Technologies\Neolithic;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Pottery extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Neolithic;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            Agriculture::get(),
            Domestication::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(2, 5);
    }
}
