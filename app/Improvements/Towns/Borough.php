<?php

namespace App\Improvements\Towns;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Industrial\CoalGasification;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class Borough extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Towns;
    }

    public function technology(): ?TechnologyType
    {
        return CoalGasification::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return Suburb::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier(YieldType::Culture, 1.33),
            new YieldModifier(YieldType::Gold, 1.33),
            new YieldModifier(YieldType::Production, 1.33),
            new YieldModifier(YieldType::Science, 1.33),
            new YieldModifier(YieldType::Food, -2.66),
        ]);
    }
}
