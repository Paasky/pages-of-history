<?php

namespace App\UnitPlatforms;

use App\Enums\UnitCapability;
use App\Enums\UnitPlatformCategory;
use App\Resources\ResourceType;
use App\Resources\Strategic\Oil;
use App\Technologies\Atomic\Satellites;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\EnergyWeapon\LaserCannon;
use App\UnitEquipment\Espionage\Spy;
use App\UnitEquipment\UnitEquipmentType;
use Illuminate\Support\Collection;

class Satellite extends UnitPlatformType
{
    public int $equipmentSlots = 3;
    public int $armorSlots = 0;
    public int $maxWeight = 3;
    public int $moves = 1;
    public int $maneuvering = 20;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect();
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            Spy::get(),
            LaserCannon::get(),
        ]);
    }

    public function category(): UnitPlatformCategory
    {
        return UnitPlatformCategory::Space;
    }

    /** @return Collection<int, UnitCapability> */
    public function modifiers(): Collection
    {
        return collect([UnitCapability::CanEnterBorders, UnitCapability::CanRebaseAnywhere, UnitCapability::InvisibleBeforeAttack]);
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
        return Satellites::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return null;
    }

    public function icon(): string
    {
        return 'fa-satellite';
    }
}
