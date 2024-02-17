<?php

namespace App\Improvements\Towns;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Atomic\Plastics;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class Suburb extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Towns;
    }

    public function technology(): ?TechnologyType
    {
        return Plastics::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return LocalCenter::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Culture, 1.66),
            new YieldModifier($this, YieldType::Gold, 1.66),
            new YieldModifier($this, YieldType::Production, 1.66),
            new YieldModifier($this, YieldType::Science, 1.66),
            new YieldModifier($this, YieldType::Food, -3.33),
        ]);
    }
}
