<?php

namespace App\UnitPlatforms\Naval;

use App\Enums\UnitCapability;
use App\Enums\UnitPlatformCategory;
use App\Technologies\Enlightenment\Navigation;
use App\Technologies\TechnologyType;
use App\UnitArmor\NoArmor;
use App\UnitArmor\UnitArmorType;
use App\UnitArmor\Vehicle\Ironclad;
use App\UnitArmor\Vehicle\Multideck;
use App\UnitEquipment\Artillery\Artillery;
use App\UnitEquipment\Cannon\Bombard;
use App\UnitEquipment\Cannon\Cannon;
use App\UnitEquipment\Diplomacy\Diplomat;
use App\UnitEquipment\Diplomacy\Envoy;
use App\UnitEquipment\Espionage\Courtesan;
use App\UnitEquipment\Espionage\Spy;
use App\UnitEquipment\Expansion\Colonist;
use App\UnitEquipment\Expansion\Pioneer;
use App\UnitEquipment\Exploring\Archeologist;
use App\UnitEquipment\Exploring\Naturalist;
use App\UnitEquipment\Trade\CargoHold;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Support\Collection;

class FullRigged extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 1;
    public int $maxWeight = 3;
    public int $moves = 5;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect([
            NoArmor::get(),
            Multideck::get(),
            Ironclad::get(),
        ]);
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            Bombard::get(),
            Cannon::get(),
            Artillery::get(),

            Colonist::get(),
            Pioneer::get(),

            Envoy::get(),
            Diplomat::get(),
            Courtesan::get(),
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
        return 'fa-sailboat';
    }

    /** @return Collection<int, UnitCapability> */
    public function modifiers(): Collection
    {
        return collect([UnitCapability::CanTravelOnSea, UnitCapability::CanTravelOnOcean]);
    }

    public function technology(): ?TechnologyType
    {
        return Navigation::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return SteamEngine::get();
    }
}
