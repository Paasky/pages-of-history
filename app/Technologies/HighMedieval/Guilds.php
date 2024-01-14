<?php

namespace App\Technologies\HighMedieval;

use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Technologies\Medieval\CropRotation;
use App\Technologies\Medieval\MetalCasting;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Guilds extends TechnologyType
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
            CropRotation::get(),
            MetalCasting::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(19, 2);
    }
}
