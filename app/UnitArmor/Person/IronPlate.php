<?php

namespace App\UnitArmor\Person;

use App\Enums\UnitArmorCategory;
use App\Enums\UnitEquipmentCategory;
use App\Enums\YieldType;
use App\Technologies\Iron\IronWorking;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersTowards;
use Illuminate\Support\Collection;

class IronPlate extends UnitArmorType
{
    public function category(): UnitArmorCategory
    {
        return UnitArmorCategory::Person;
    }

    public function technology(): ?TechnologyType
    {
        return IronWorking::get();
    }

    public function upgradesTo(): ?UnitArmorType
    {
        return Chainmail::get();
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
