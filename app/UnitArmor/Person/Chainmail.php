<?php

namespace App\UnitArmor\Person;

use App\Enums\UnitArmorCategory;
use App\Enums\UnitEquipmentCategory;
use App\Enums\YieldType;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersTowards;
use Illuminate\Support\Collection;

class Chainmail extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Person;
    }

    public function technology(): ?TechnologyType
    {
        return \App\Technologies\Medieval\Chainmail::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return SteelPlate::get();
    }

    public function yieldModifiers(): Collection
    {
        return parent::yieldModifiers()->add(
            new YieldModifiersTowards(
                new YieldModifier($this, YieldType::Strength, percent: 10),
                UnitEquipmentCategory::Melee
            )
        );
    }
}
