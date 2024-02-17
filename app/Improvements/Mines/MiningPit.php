<?php

namespace App\Improvements\Mines;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Neolithic\StoneWorking;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class MiningPit extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Mines;
    }

    public function technology(): ?TechnologyType
    {
        return StoneWorking::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return Mine::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Gold, 0.5),
            new YieldModifier($this, YieldType::Production, 0.5),
        ]);
    }
}
