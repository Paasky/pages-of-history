<?php

namespace App\Improvements\Fisheries;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Industrial\Biology;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class FactoryFishery extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Fisheries;
    }

    public function technology(): ?TechnologyType
    {
        return Biology::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return AutomatedFishery::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier(YieldType::Food, 2.5),
            new YieldModifier(YieldType::Gold, 2.5),
        ]);
    }
}
