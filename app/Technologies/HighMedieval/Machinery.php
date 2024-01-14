<?php

namespace App\Technologies\HighMedieval;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Machinery extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::HighMedieval;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            Guilds::get(),
            Steel::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(20, 3);
    }
}
