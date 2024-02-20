<?php

namespace App\UnitArmor\Parachute;

use App\Enums\UnitArmorCategory;
use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\Technologies\Modern\CombinedArms;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersAgainst;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Parachute extends UnitArmorType
{
    public int $weight = 1;

    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Parachute;
    }

    public function technology(): ?TechnologyType
    {
        return CombinedArms::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return HALO::get();
    }

    /** @return Collection<int, YieldModifier|YieldModifiersFor> */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::ParachuteRange, 5),
            new YieldModifier($this, YieldType::Cost, percent: 25),
            new YieldModifiersAgainst(
                new YieldModifier($this, YieldType::Strength, percent: -10),
                UnitPlatformCategory::Vehicle
            )
        ]);
    }
}
