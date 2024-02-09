<?php

namespace App\UnitArmor\Person;

use App\Enums\UnitArmorCategory;
use App\Enums\UnitEquipmentCategory;
use App\Enums\YieldType;
use App\Technologies\Digital\Composites;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersAgainst;
use Illuminate\Support\Collection;

class BodyArmor extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Person;
    }

    public function technology(): ?TechnologyType
    {
        return Composites::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return null;
    }

    public function yieldModifiers(): Collection
    {
        return parent::yieldModifiers()->add(
            new YieldModifiersAgainst(
                new YieldModifier(YieldType::Strength, percent: 10),
                UnitEquipmentCategory::Firearm
            )
        );
    }
}
