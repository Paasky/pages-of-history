<?php

namespace App\Improvements\Forts;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Enlightenment\Metallurgy;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class StarFort extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Forts;
    }

    public function technology(): ?TechnologyType
    {
        return Metallurgy::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return Trench::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Culture, 1),
            new YieldModifier($this, YieldType::Defense, percent: 100),
        ]);
    }
}
