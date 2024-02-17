<?php

namespace App\Improvements\Forts;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\HighMedieval\Castles;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class Castle extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Forts;
    }

    public function technology(): ?TechnologyType
    {
        return Castles::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return StarFort::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Culture, 2),
            new YieldModifier($this, YieldType::Defense, percent: 75),
        ]);
    }
}
