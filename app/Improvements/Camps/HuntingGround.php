<?php

namespace App\Improvements\Camps;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Bronze\AnimalHusbandry;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class HuntingGround extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Camps;
    }

    public function technology(): ?TechnologyType
    {
        return AnimalHusbandry::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return Manor::get();
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
