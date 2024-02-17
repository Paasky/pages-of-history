<?php

namespace App\Improvements\Mines;

use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Technologies\Industrial\SteamPower;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class SteamMine extends ImprovementType
{
    public function category(): ImprovementCategory
    {
        return ImprovementCategory::Mines;
    }

    public function technology(): ?TechnologyType
    {
        return SteamPower::get();
    }

    public function upgradesTo(): ?ImprovementType
    {
        return MechanizedMine::get();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Gold, 2),
            new YieldModifier($this, YieldType::Production, 2),
        ]);
    }
}
