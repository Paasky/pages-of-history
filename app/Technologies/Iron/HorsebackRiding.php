<?php

namespace App\Technologies\Iron;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Bronze\Currency;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class HorsebackRiding extends TechnologyType
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
            Currency::get()
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(9, 2);
    }
}
