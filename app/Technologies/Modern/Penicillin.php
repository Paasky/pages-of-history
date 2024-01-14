<?php

namespace App\Technologies\Modern;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Gilded\ReplaceableParts;
use App\Technologies\Gilded\StainlessSteel;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Penicillin extends TechnologyType
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
            StainlessSteel::get(),
            ReplaceableParts::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(39, 3);
    }
}
