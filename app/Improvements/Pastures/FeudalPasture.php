<?php

namespace App\Improvements\Pastures;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Medieval\Feudalism;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class FeudalPasture extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Pastures;
    }

    public function technology(): ?TechnologyType
    {
        return Feudalism::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return Feedlot::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Food, 1.5),
            new YieldModifier($this, YieldType::Gold, 1.5),
        ]);
    }
}
