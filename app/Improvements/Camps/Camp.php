<?php

namespace App\Improvements\Camps;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Neolithic\Trapping;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class Camp extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Camps;
    }

    public function technology(): ?TechnologyType
    {
        return Trapping::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return HuntingGround::get();
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
