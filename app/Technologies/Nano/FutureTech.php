<?php

namespace App\Technologies\Nano;

use App\Coordinate;
use App\Enums\ImprovementCategory;
use App\Enums\TechnologyEra;
use App\Enums\YieldType;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class FutureTech extends TechnologyType
{
    public function era(): TechnologyEra
    {
        return TechnologyEra::Nano;
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function requires(): Collection
    {
        return collect([
            FusionPropulsion::get(),
            Cloning::get(),
            Nanobots::get(),
        ]);
    }

    public function xy(): Coordinate
    {
        return new Coordinate(58, 7);
    }

    /**
     * @return Collection<int, YieldModifiersFor>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifiersFor(
                collect([
                    new YieldModifier(YieldType::Gold, 1),
                    new YieldModifier(YieldType::Production, 1),
                    new YieldModifier(YieldType::Health, 1),
                    new YieldModifier(YieldType::Happiness, 1),
                ]),
                ImprovementCategory::Cities
            ),
        ]);
    }
}
