<?php

namespace App\Improvements\Towns;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Iron\Bureaucracy;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class Village extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Towns;
    }

    public function technology(): ?TechnologyType
    {
        return Bureaucracy::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return Town::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Culture, 0.66),
            new YieldModifier($this, YieldType::Gold, 0.66),
            new YieldModifier($this, YieldType::Production, 0.66),
            new YieldModifier($this, YieldType::Science, 0.66),
            new YieldModifier($this, YieldType::Food, -1.33),
        ]);
    }
}
