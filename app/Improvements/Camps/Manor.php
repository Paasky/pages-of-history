<?php

namespace App\Improvements\Camps;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Medieval\Feudalism;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class Manor extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Camps;
    }

    public function technology(): ?TechnologyType
    {
        return Feudalism::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return NatureReserve::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier(YieldType::Food, 1.5),
            new YieldModifier(YieldType::Gold, 1.5),
        ]);
    }
}
