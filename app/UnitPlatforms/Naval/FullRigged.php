<?php

namespace App\UnitPlatforms\Naval;

use App\Enums\UnitCapability;
use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\Technologies\Enlightenment\Navigation;
use App\Technologies\TechnologyType;
use App\UnitArmor\NoArmor;
use App\UnitArmor\Stealth\Privateer;
use App\UnitArmor\UnitArmorType;
use App\UnitArmor\Vehicle\Ironclad;
use App\UnitArmor\Vehicle\Multideck;
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
use App\UnitEquipment\NavalAssault\Buccaneers;
use App\UnitEquipment\NavalAssault\MusketMarines;
use App\UnitEquipment\Trade\CargoHold;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class FullRigged extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 1;
    public int $maxWeight = 3;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect([
            NoArmor::get(),
            Multideck::get(),
            Privateer::get(),
            Ironclad::get(),
        ]);
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            Buccaneers::get(),
            MusketMarines::get(),

            Bombard::get(),
            Cannon::get(),

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

    public function name(): string
    {
        return 'Full-Rigged';
    }

    public function technology(): ?TechnologyType
    {
        return Navigation::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return SteamEngine::get();
    }

    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Cost, percent: 50),
            new YieldModifier($this, YieldType::Moves, 5),
        ]);
    }
}
