<?php

namespace App\Improvements\Forts;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Bronze\Sieging;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class Fort extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Forts;
    }

    public function technology(): ?TechnologyType
    {
        return Sieging::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return Castle::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier(YieldType::Culture, 1.5),
            new YieldModifier(YieldType::Defense, percent: 50),
        ]);
    }
}
