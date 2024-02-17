<?php

namespace App\UnitPlatforms\Naval;

use App\Enums\UnitCapability;
use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\Resources\ResourceType;
use App\Resources\Strategic\Oil;
use App\Technologies\Modern\HydroEngineering;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\Torpedo\HomingTorpedo;
use App\UnitEquipment\Torpedo\Torpedo;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class Submarine extends UnitPlatformType
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
            Torpedo::get(),
            HomingTorpedo::get(),
        ]);
    }

    public function category(): UnitPlatformCategory
    {
        return UnitPlatformCategory::Naval;
    }

    public function icon(): string
    {
        return 'fa-water';
    }

    /** @return Collection<int, UnitCapability> */
    public function modifiers(): Collection
    {
        return collect([
            UnitCapability::CanTravelOnSea,
            UnitCapability::CanTravelOnOcean,
            UnitCapability::InvisibleBeforeAttack,
        ]);
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
        return HydroEngineering::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return ElectricSubmarine::get();
    }

    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Cost, percent: 55),
            new YieldModifier($this, YieldType::Moves, 4),
        ]);
    }
}
