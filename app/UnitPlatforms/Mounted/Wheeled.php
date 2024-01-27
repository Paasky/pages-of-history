<?php

namespace App\UnitPlatforms\Mounted;

use App\Enums\UnitPlatformCategory;
use App\Resources\ResourceType;
use App\Resources\Strategic\Oil;
use App\Technologies\Gilded\Combustion;
use App\Technologies\TechnologyType;
use App\UnitArmor\Person\BodyArmor;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\Diplomacy\Diplomat;
use App\UnitEquipment\Espionage\Spy;
use App\UnitEquipment\Expansion\Pioneer;
use App\UnitEquipment\Exploring\Archeologist;
use App\UnitEquipment\Firearm\AssaultRifle;
use App\UnitEquipment\Firearm\LaserRifle;
use App\UnitEquipment\Firearm\RepeatingRifle;
use App\UnitEquipment\Firearm\ScopeRifle;
use App\UnitEquipment\SkirmishFirearm\AiGuidedMortar;
use App\UnitEquipment\SkirmishFirearm\MachineGun;
use App\UnitEquipment\SkirmishFirearm\Mortar;
use App\UnitEquipment\Trade\CargoHold;
use App\UnitEquipment\Trade\Container;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Support\Collection;

class Wheeled extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 1;
    public int $maxWeight = 3;
    public int $moves = 4;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect([
            BodyArmor::get(),
        ]);
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            Pioneer::get(),

            Spy::get(),
            Diplomat::get(),
            Archeologist::get(),

            CargoHold::get(),
            Container::get(),

            RepeatingRifle::get(),
            AssaultRifle::get(),
            ScopeRifle::get(),
            LaserRifle::get(),
            MachineGun::get(),
            Mortar::get(),
            AiGuidedMortar::get(),
        ]);
    }

    public function category(): UnitPlatformCategory
    {
        return UnitPlatformCategory::Mounted;
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
        return Combustion::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return null;
    }

    public function icon(): string
    {
        return 'fa-truck';
    }
}
