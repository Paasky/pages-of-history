<?php

namespace App\Improvements\Towns;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Information\MassSurveillance;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class LocalCenter extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Towns;
    }

    public function technology(): ?TechnologyType
    {
        return MassSurveillance::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return null;
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Culture, 2),
            new YieldModifier($this, YieldType::Gold, 2),
            new YieldModifier($this, YieldType::Production, 2),
            new YieldModifier($this, YieldType::Science, 2),
            new YieldModifier($this, YieldType::Food, -4),
        ]);
    }
}
