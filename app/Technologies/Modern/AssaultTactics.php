<?php

namespace App\Technologies\Modern;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Gilded\Ballistics;
use App\Technologies\Gilded\Flight;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class AssaultTactics extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Modern;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            Ballistics::get(),
            Flight::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(39, 7);
    }
}
