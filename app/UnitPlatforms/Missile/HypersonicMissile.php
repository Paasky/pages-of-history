<?php

namespace App\UnitPlatforms\Missile;

use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\Resources\ResourceType;
use App\Resources\Strategic\Oil;
use App\Technologies\Information\Graphene;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\Bomb\AiGuidedBomb;
use App\UnitEquipment\Bomb\GuidedBomb;
use App\UnitEquipment\MassDestruction\AtomBomb;
use App\UnitEquipment\MassDestruction\GasBomb;
use App\UnitEquipment\MassDestruction\VirusBomb;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class HypersonicMissile extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 0;
    public int $maxWeight = 2;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect();
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            GuidedBomb::get(),
            AiGuidedBomb::get(),

            GasBomb::get(),
            AtomBomb::get(),
            VirusBomb::get(),
        ]);
    }

    public function category(): UnitPlatformCategory
    {
        return UnitPlatformCategory::Missile;
    }

    public function icon(): string
    {
        return 'fa-rocket';
    }

    /**
     * @return Collection<int, ResourceType>
     */
    public function resources(): Collection
    {
        return collect([Oil::get()]);
    }

    public function technology(): ?TechnologyType
    {
        return Graphene::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return null;
    }

    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Cost, percent: 20),
            new YieldModifier($this, YieldType::Agility, 20),
            new YieldModifier($this, YieldType::Range, 8),
        ]);
    }
}
