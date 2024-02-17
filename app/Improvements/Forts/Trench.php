<?php

namespace App\Improvements\Forts;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Gilded\Dynamite;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class Trench extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Forts;
    }

    public function technology(): ?TechnologyType
    {
        return Dynamite::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return ModernTrench::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Defense, percent: 125),
        ]);
    }
}
