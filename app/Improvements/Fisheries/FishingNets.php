<?php

namespace App\Improvements\Fisheries;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Neolithic\Fishing;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class FishingNets extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Fisheries;
    }

    public function technology(): ?TechnologyType
    {
        return Fishing::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return FishingBoats::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Food, 0.5),
            new YieldModifier($this, YieldType::Gold, 0.5),
        ]);
    }
}
