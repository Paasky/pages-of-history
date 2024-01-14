<?php

namespace App\Technologies\Medieval;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Classical\TreadwheelCrane;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Paper extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Medieval;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            TreadwheelCrane::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(15, 4);
    }
}
