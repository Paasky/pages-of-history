<?php

namespace App\UnitPlatforms\Naval;

use App\Enums\UnitCapability;
use App\Enums\UnitPlatformCategory;
use App\Technologies\Industrial\Industrialization;
use App\Technologies\TechnologyType;
use App\UnitArmor\Camouflage\Camouflage;
use App\UnitArmor\UnitArmorType;
use App\UnitArmor\Vehicle\Ironclad;
use App\UnitArmor\Vehicle\Multideck;
use App\UnitArmor\Vehicle\SteelArmor;
use App\UnitEquipment\Artillery\Artillery;
use App\UnitEquipment\Artillery\Howitzer;
use App\UnitEquipment\Cannon\Cannon;
use App\UnitEquipment\Diplomacy\Diplomat;
use App\UnitEquipment\Espionage\Spy;
use App\UnitEquipment\Expansion\Pioneer;
use App\UnitEquipment\Exploring\Archeologist;
use App\UnitEquipment\Exploring\Naturalist;
use App\UnitEquipment\Torpedo\Torpedo;
use App\UnitEquipment\Trade\CargoHold;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Support\Collection;

class SteamEngine extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 1;
    public int $maxWeight = 3;
    public int $moves = 6;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect([
            Multideck::get(),
            Ironclad::get(),
            SteelArmor::get(),

            Camouflage::get(),
        ]);
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            Cannon::get(),
            Artillery::get(),
            Howitzer::get(),

            Torpedo::get(),

            Pioneer::get(),
            Diplomat::get(),
            Spy::get(),
            Naturalist::get(),
            Archeologist::get(),

            CargoHold::get(),
        ]);
    }

    public function category(): UnitPlatformCategory
    {
        return UnitPlatformCategory::Naval;
    }

    public function icon(): string
    {
        return 'fa-ship';
    }

    /** @return Collection<int, UnitCapability> */
    public function modifiers(): Collection
    {
        return collect([UnitCapability::CanTravelOnSea, UnitCapability::CanTravelOnOcean]);
    }

    public function technology(): ?TechnologyType
    {
        return Industrialization::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return DieselElectric::get();
    }
}
