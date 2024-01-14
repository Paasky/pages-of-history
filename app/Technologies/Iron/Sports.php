<?php

namespace App\Technologies\Iron;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Sports extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Iron;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            Construction::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(11, 2);
    }
}
