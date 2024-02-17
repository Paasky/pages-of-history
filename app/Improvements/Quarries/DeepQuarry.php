<?php

namespace App\Improvements\Quarries;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\HighMedieval\Machinery;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class DeepQuarry extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Quarries;
    }

    public function technology(): ?TechnologyType
    {
        return Machinery::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return SteamQuarry::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Gold, 1.5),
            new YieldModifier($this, YieldType::Production, 1.5),
        ]);
    }
}
