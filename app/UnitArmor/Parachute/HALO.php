<?php

namespace App\UnitArmor\Parachute;

use App\Enums\UnitArmorCategory;
use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\Technologies\Digital\SatellitePositioning;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use App\Yields\YieldModifiersTowards;
use Illuminate\Support\Collection;

class HALO extends UnitArmorType
{
    public int $weight = 1;

    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Parachute;
    }

    public function name(): string
    {
        return 'HALO';
    }

    public function technology(): ?TechnologyType
    {
        return SatellitePositioning::get();
    }

    public function shortName(): string
    {
        return 'HALO';
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return null;
    }

    /** @return Collection<int, YieldModifier|YieldModifiersFor> */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::ParachuteRange, 10),
            new YieldModifier($this, YieldType::Cost, percent: 33),
            new YieldModifiersTowards(
                new YieldModifier($this, YieldType::Strength, percent: -10),
                UnitPlatformCategory::Vehicle
            )
        ]);
    }
}
