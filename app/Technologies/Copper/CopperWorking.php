<?php

namespace App\Technologies\Copper;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Neolithic\Pottery;
use App\Technologies\Neolithic\WoodWorking;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class CopperWorking extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Copper;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            WoodWorking::get(),
            Pottery::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(3, 4);
    }
}
