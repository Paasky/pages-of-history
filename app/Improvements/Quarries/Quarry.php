<?php

namespace App\Improvements\Quarries;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Bronze\Masonry;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class Quarry extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Quarries;
    }

    public function technology(): ?TechnologyType
    {
        return Masonry::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return DeepQuarry::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Gold, 1),
            new YieldModifier($this, YieldType::Production, 1),
        ]);
    }
}
