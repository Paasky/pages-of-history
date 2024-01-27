<?php

namespace App\UnitPlatforms\Air;

use App\Enums\UnitPlatformCategory;
use App\Resources\ResourceType;
use App\Resources\Strategic\Oil;
use App\Technologies\Gilded\Flight;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\AirGun\AirMachineGun;
use App\UnitEquipment\Bomb\LightBomb;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Support\Collection;

class Biplane extends UnitPlatformType
{
    public int $equipmentSlots = 1;
    public int $armorSlots = 0;
    public int $maxWeight = 1;
    public int $moves = 1;
    public int $range = 4;
    public int $maneuvering = 2;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect();
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
}
