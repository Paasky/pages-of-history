<?php

namespace App\UnitPlatforms\Naval;

use App\UnitArmor\UnitArmorType;
use App\Enums\UnitPlatformCategory;
use App\Enums\UnitCapability;
use App\UnitPlatforms\UnitPlatformType;
use App\Resources\ResourceType;
use App\Resources\Strategic\Oil;
use App\Technologies\Atomic\Robotics;
use App\Technologies\TechnologyType;
use App\UnitEquipment\MissileBay\MissileBay;
use App\UnitEquipment\Torpedo\AiTorpedo;
use App\UnitEquipment\Torpedo\GuidedTorpedo;
use App\UnitEquipment\Torpedo\HomingTorpedo;
use App\UnitEquipment\UnitEquipmentType;
use Illuminate\Support\Collection;

class NuclearSubmarine extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 0;
    public int $maxWeight = 2;
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
            UnitCapability::CanTravelOnIce,
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
        return Robotics::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return null;
    }
}
