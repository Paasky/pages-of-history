<?php

namespace App\Technologies\Enlightenment;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Constitution extends TechnologyType
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
            Liberalism::get(),
            RoyalCharter::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(30, 3);
    }
}
