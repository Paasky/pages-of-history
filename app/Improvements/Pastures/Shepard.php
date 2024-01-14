<?php

namespace App\Improvements\Pastures;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Neolithic\Domestication;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class Shepard extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Pastures;
    }

    public function technology(): ?TechnologyType
    {
        return Domestication::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return Pasture::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier(YieldType::Food, 0.5),
            new YieldModifier(YieldType::Gold, 0.5),
        ]);
    }
}
