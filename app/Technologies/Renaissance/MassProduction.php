<?php

namespace App\Technologies\Renaissance;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\HighMedieval\Optics;
use App\Technologies\HighMedieval\WeavingMachine;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class MassProduction extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Renaissance;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            Optics::get(),
            WeavingMachine::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(23, 2);
    }
}
