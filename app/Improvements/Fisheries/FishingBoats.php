<?php

namespace App\Improvements\Fisheries;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Copper\Sailing;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class FishingBoats extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Fisheries;
    }

    public function technology(): ?TechnologyType
    {
        return Sailing::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return Fishery::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier(YieldType::Food, 1),
            new YieldModifier(YieldType::Gold, 1),
        ]);
    }
}
