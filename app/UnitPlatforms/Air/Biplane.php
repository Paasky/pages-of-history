<?php

namespace App\UnitPlatforms\Air;

use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\Resources\ResourceType;
use App\Resources\Strategic\Oil;
use App\Technologies\Gilded\Flight;
use App\Technologies\TechnologyType;
use App\UnitArmor\NoArmor;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\AirGun\AirMachineGun;
use App\UnitEquipment\Bomb\LightBomb;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class Biplane extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 0;
    public int $maxWeight = 2;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect([NoArmor::get()]);
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            AirMachineGun::get(),
            LightBomb::get(),
        ]);
    }

    public function category(): UnitPlatformCategory
    {
        return UnitPlatformCategory::Air;
    }

    public function icon(): string
    {
        return 'fa-plane';
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
        return Flight::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return Monocoque::get();
    }

    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier(YieldType::Agility, 2),
            new YieldModifier(YieldType::Moves, 1),
            new YieldModifier(YieldType::Range, 4),
        ]);
    }
}
