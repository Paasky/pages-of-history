<?php

namespace App\Improvements\Towns;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\HighMedieval\Guilds;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class Town extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Towns;
    }

    public function technology(): ?TechnologyType
    {
        return Guilds::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return Borough::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Culture, 1),
            new YieldModifier($this, YieldType::Gold, 1),
            new YieldModifier($this, YieldType::Production, 1),
            new YieldModifier($this, YieldType::Science, 1),
            new YieldModifier($this, YieldType::Food, -2),
        ]);
    }
}
