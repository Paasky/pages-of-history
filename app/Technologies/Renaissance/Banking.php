<?php

namespace App\Technologies\Renaissance;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\HighMedieval\BookBinding;
use App\Technologies\HighMedieval\WeavingMachine;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Banking extends TechnologyType
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
            WeavingMachine::get(),
            BookBinding::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(23, 4);
    }
}
