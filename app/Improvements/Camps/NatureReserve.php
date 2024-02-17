<?php

namespace App\Improvements\Camps;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Atomic\Environmentalism;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class NatureReserve extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Camps;
    }

    public function technology(): ?TechnologyType
    {
        return Environmentalism::get();
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
            new YieldModifier($this, YieldType::Food, 1),
            new YieldModifier($this, YieldType::Gold, 2),
        ]);
    }
}
