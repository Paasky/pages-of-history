<?php

namespace App\Technologies\HighMedieval;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Medieval\DivineRight;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class MilitaryTactics extends TechnologyType
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
            DivineRight::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(19, 6);
    }
}
