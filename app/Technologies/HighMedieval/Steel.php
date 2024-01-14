<?php

namespace App\Technologies\HighMedieval;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Medieval\DivineRight;
use App\Technologies\Medieval\MetalCasting;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Steel extends TechnologyType
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
            MetalCasting::get(),
            DivineRight::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(19, 4);
    }
}
