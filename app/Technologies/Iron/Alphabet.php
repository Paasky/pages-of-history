<?php

namespace App\Technologies\Iron;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Bronze\CodeOfLaw;
use App\Technologies\Bronze\OrganizedReligion;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Alphabet extends TechnologyType
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
            CodeOfLaw::get(),
            OrganizedReligion::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(9, 6);
    }
}
