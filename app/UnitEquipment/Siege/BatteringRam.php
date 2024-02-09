<?php

namespace App\UnitEquipment\Siege;

use App\Enums\ImprovementCategory;
use App\Enums\UnitEquipmentCategory;
use App\Enums\YieldType;
use App\Technologies\Bronze\Sieging;
use App\Technologies\TechnologyType;
use App\UnitEquipment\UnitEquipmentType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersAgainst;
use Illuminate\Support\Collection;

class BatteringRam extends UnitEquipmentType
{
    public function category(): UnitEquipmentCategory
    {
        return UnitEquipmentCategory::Siege;
    }

    public function technology(): ?TechnologyType
    {
        return Sieging::get();
    }

    public function upgradesTo(): ?UnitEquipmentType
    {
        return Catapult::get();
    }

    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifiersAgainst(
                collect([new YieldModifier(YieldType::Attack, percent: 50)]),
                [ImprovementCategory::Cities, ImprovementCategory::Forts]
            ),
        ]);
    }
}
