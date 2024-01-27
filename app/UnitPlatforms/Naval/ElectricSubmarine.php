<?php

namespace App\UnitPlatforms\Naval;

use App\Enums\UnitCapability;
use App\Enums\UnitPlatformCategory;
use App\Resources\ResourceType;
use App\Resources\Strategic\Oil;
use App\Technologies\Atomic\Plastics;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\MissileBay\MissileBay;
use App\UnitEquipment\Torpedo\AiTorpedo;
use App\UnitEquipment\Torpedo\GuidedTorpedo;
use App\UnitEquipment\Torpedo\HomingTorpedo;
use App\UnitEquipment\Torpedo\Torpedo;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Support\Collection;

class ElectricSubmarine extends UnitPlatformType
{
    public int $equipmentSlots = 1;
    public int $armorSlots = 0;
    public int $maxWeight = 1;
    public int $moves = 5;

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
        return collect([UnitCapability::CanTravelOnSea, UnitCapability::CanTravelOnOcean, UnitCapability::InvisibleBeforeAttack]);
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
        return NuclearSubmarine::get();
    }
}
