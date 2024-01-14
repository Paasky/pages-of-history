<?php

namespace App\Technologies\Neolithic;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Fishing extends TechnologyType
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
        return collect();
    }

    public function xy(): Coordinate
    {
        return new Coordinate(1, 9);
    }
}
