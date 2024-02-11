<?php

namespace App\UnitPlatforms\Naval;

use App\Enums\UnitCapability;
use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\Technologies\Renaissance\SquareRigging;
use App\Technologies\TechnologyType;
use App\UnitArmor\NoArmor;
use App\UnitArmor\Stealth\Privateer;
use App\UnitArmor\UnitArmorType;
use App\UnitArmor\Vehicle\Multideck;
use App\UnitEquipment\Cannon\Bombard;
use App\UnitEquipment\Cannon\Cannon;
use App\UnitEquipment\Diplomacy\Diplomat;
use App\UnitEquipment\Diplomacy\Envoy;
use App\UnitEquipment\Espionage\Courtesan;
use App\UnitEquipment\Espionage\Spy;
use App\UnitEquipment\Expansion\Colonist;
use App\UnitEquipment\Exploring\Explorer;
use App\UnitEquipment\NavalAssault\Buccaneers;
use App\UnitEquipment\NavalAssault\RaidingParty;
use App\UnitEquipment\Trade\CargoHold;
use App\UnitEquipment\Trade\Merchant;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class CarvelHull extends UnitPlatformType
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
        ]);
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            RaidingParty::get(),
            Buccaneers::get(),

            Bombard::get(),
            Cannon::get(),

            Colonist::get(),
            Merchant::get(),
            CargoHold::get(),

            Envoy::get(),
            Diplomat::get(),
            Courtesan::get(),
            Spy::get(),
            Explorer::get(),
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
        return SquareRigging::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return FullRigged::get();
    }

    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier(YieldType::Cost, percent: 40),
            new YieldModifier(YieldType::Moves, 4),
        ]);
    }
}
