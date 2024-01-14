<?php

namespace App\Improvements\Pastures;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Atomic\Macroeconomics;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class FactoryFarm extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Pastures;
    }

    public function technology(): ?TechnologyType
    {
        return Macroeconomics::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return AutomatedFactoryFarm::get();
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
