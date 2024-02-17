<?php

namespace App\UnitPlatforms\Naval;

use App\Enums\UnitCapability;
use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\Resources\ResourceType;
use App\Resources\Strategic\Oil;
use App\Technologies\Atomic\Plastics;
use App\Technologies\TechnologyType;
use App\UnitArmor\NoArmor;
use App\UnitArmor\Stealth\AdvancedStealth;
use App\UnitArmor\Stealth\Stealth;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\MissileBay\MissileBay;
use App\UnitEquipment\Torpedo\AiTorpedo;
use App\UnitEquipment\Torpedo\GuidedTorpedo;
use App\UnitEquipment\Torpedo\HomingTorpedo;
use App\UnitEquipment\Torpedo\Torpedo;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class ElectricSubmarine extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 1;
    public int $maxWeight = 2;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect([
            NoArmor::get(),
            Stealth::get(),
            AdvancedStealth::get(),
        ]);
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            Torpedo::get(),
            HomingTorpedo::get(),
            GuidedTorpedo::get(),
            AiTorpedo::get(),

            MissileBay::get(),
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
        return Plastics::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return null;
    }

    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Cost, percent: 75),
            new YieldModifier($this, YieldType::Moves, 5),
        ]);
    }
}
