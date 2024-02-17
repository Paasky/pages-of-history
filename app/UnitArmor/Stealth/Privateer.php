<?php

namespace App\UnitArmor\Stealth;

use App\Enums\UnitArmorCategory;
use App\Enums\YieldType;
use App\Technologies\Enlightenment\Mercantilism;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\UnitArmor\Vehicle\Ironclad;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Privateer extends UnitArmorType
{
    public int $weight = 0;

    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Stealth;
    }

    public function icon(): string
    {
        return 'fa-skull-crossbones';
    }

    public function technology(): ?TechnologyType
    {
        return Mercantilism::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return Ironclad::get();
    }

    /** @return Collection<int, YieldModifier|YieldModifiersFor> */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier(
                $this,
                YieldType::Cost,
                percent: 25
            ),
        ]);
    }
}
