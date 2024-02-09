<?php

namespace App\UnitArmor;

use App\Enums\UnitArmorCategory;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class NoArmor extends UnitArmorType
{
    public int $weight = 0;

    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::None;
    }

    public function technology(): ?TechnologyType
    {
        return null;
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return null;
    }

    /** @return Collection<int, YieldModifier|YieldModifiersFor> */
    public function yieldModifiers(): Collection
    {
        return collect();
    }
}
