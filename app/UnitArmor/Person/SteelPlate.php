<?php

namespace App\UnitArmor\Person;

use App\Enums\UnitArmorCategory;
use App\Enums\UnitEquipmentCategory;
use App\Enums\YieldType;
use App\Technologies\HighMedieval\Steel;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersAgainst;
use Illuminate\Support\Collection;

class SteelPlate extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Person;
    }

    public function technology(): ?TechnologyType
    {
        return Steel::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return BodyArmor::get();
    }

    public function yieldModifiers(): Collection
    {
        return parent::yieldModifiers()->add(
            new YieldModifiersAgainst(
                new YieldModifier($this, YieldType::Strength, percent: 10),
                UnitEquipmentCategory::Melee
            )
        );
    }
}
