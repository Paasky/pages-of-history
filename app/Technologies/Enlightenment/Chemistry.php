<?php

namespace App\Technologies\Enlightenment;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Renaissance\Astronomy;
use App\Technologies\Renaissance\Printing;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Chemistry extends TechnologyType
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
            Astronomy::get(),
            Printing::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(27, 4);
    }
}
