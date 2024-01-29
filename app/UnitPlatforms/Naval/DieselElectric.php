<?php

namespace App\UnitPlatforms\Naval;

use App\Enums\UnitCapability;
use App\Enums\UnitPlatformCategory;
use App\Technologies\Modern\Electronics;
use App\Technologies\TechnologyType;
use App\UnitArmor\Camouflage\Camouflage;
use App\UnitArmor\NoArmor;
use App\UnitArmor\Stealth\AdvancedStealth;
use App\UnitArmor\Stealth\Stealth;
use App\UnitArmor\UnitArmorType;
use App\UnitArmor\Vehicle\ActiveDefense;
use App\UnitArmor\Vehicle\CompositeArmor;
use App\UnitArmor\Vehicle\HeavyArmor;
use App\UnitArmor\Vehicle\SteelArmor;
use App\UnitEquipment\AntiAir\AiMissile;
use App\UnitEquipment\AntiAir\AntiAirGun;
use App\UnitEquipment\AntiAir\GuidedMissile;
use App\UnitEquipment\AntiAir\HomingMissile;
use App\UnitEquipment\Artillery\Artillery;
use App\UnitEquipment\Artillery\Howitzer;
use App\UnitEquipment\Diplomacy\Diplomat;
use App\UnitEquipment\EnergyWeapon\Railgun;
use App\UnitEquipment\Espionage\Spy;
use App\UnitEquipment\Expansion\Pioneer;
use App\UnitEquipment\Exploring\Archeologist;
use App\UnitEquipment\FlightDeck\AiRadarDeck;
use App\UnitEquipment\FlightDeck\CatapultDeck;
use App\UnitEquipment\FlightDeck\RadarDeck;
use App\UnitEquipment\FlightDeck\WoodenDeck;
use App\UnitEquipment\MissileBay\MissileBay;
use App\UnitEquipment\RocketArtillery\AiRocketSystem;
use App\UnitEquipment\RocketArtillery\RocketSystem;
use App\UnitEquipment\Torpedo\AiTorpedo;
use App\UnitEquipment\Torpedo\GuidedTorpedo;
use App\UnitEquipment\Torpedo\HomingTorpedo;
use App\UnitEquipment\Torpedo\Torpedo;
use App\UnitEquipment\Trade\CargoHold;
use App\UnitEquipment\Trade\ContainerHold;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Support\Collection;

class DieselElectric extends UnitPlatformType
{
    public int $equipmentSlots = 3;
    public int $armorSlots = 1;
    public int $maxWeight = 3;
    public int $moves = 6;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect([
            NoArmor::get(),

            SteelArmor::get(),
            HeavyArmor::get(),
            CompositeArmor::get(),
            ActiveDefense::get(),

            Camouflage::get(),
            Stealth::get(),
            AdvancedStealth::get(),
        ]);
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            Pioneer::get(),
            Diplomat::get(),
            Spy::get(),
            Archeologist::get(),

            CargoHold::get(),
            ContainerHold::get(),

            Artillery::get(),
            Howitzer::get(),
            RocketSystem::get(),
            AiRocketSystem::get(),
            Railgun::get(),

            AntiAirGun::get(),
            HomingMissile::get(),
            GuidedMissile::get(),
            AiMissile::get(),

            Torpedo::get(),
            HomingTorpedo::get(),
            GuidedTorpedo::get(),
            AiTorpedo::get(),

            MissileBay::get(),

            WoodenDeck::get(),
            CatapultDeck::get(),
            RadarDeck::get(),
            AiRadarDeck::get(),
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
        return Electronics::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return null;
    }
}
