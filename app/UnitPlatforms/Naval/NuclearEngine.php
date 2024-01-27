<?php

namespace App\UnitPlatforms\Naval;

use App\UnitArmor\UnitArmorType;
use App\UnitArmor\Vehicle\ActiveDefense;
use App\UnitArmor\Vehicle\CompositeArmor;
use App\UnitArmor\Vehicle\HeavyArmor;
use App\Enums\UnitPlatformCategory;
use App\Enums\UnitCapability;
use App\UnitEquipment\Trade\CargoHold;
use App\UnitEquipment\Trade\Container;
use App\UnitPlatforms\UnitPlatformType;
use App\Technologies\Atomic\Robotics;
use App\Technologies\TechnologyType;
use App\UnitEquipment\AntiAir\AiMissile;
use App\UnitEquipment\AntiAir\GuidedMissile;
use App\UnitEquipment\AntiAir\HomingMissile;
use App\UnitEquipment\Artillery\Howitzer;
use App\UnitEquipment\FlightDeck\AiRadarDeck;
use App\UnitEquipment\FlightDeck\CatapultDeck;
use App\UnitEquipment\FlightDeck\RadarDeck;
use App\UnitEquipment\MissileBay\MissileBay;
use App\UnitEquipment\EnergyWeapon\Railgun;
use App\UnitEquipment\RocketArtillery\AiRocketSystem;
use App\UnitEquipment\RocketArtillery\RocketSystem;
use App\UnitEquipment\UnitEquipmentType;
use Illuminate\Support\Collection;

class NuclearEngine extends UnitPlatformType
{
    public int $equipmentSlots = 3;
    public int $armorSlots = 1;
    public int $maxWeight = 4;
    public int $moves = 6;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect([
            HeavyArmor::get(),
            CompositeArmor::get(),
            ActiveDefense::get(),
        ]);
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            Howitzer::get(),
            RocketSystem::get(),
            AiRocketSystem::get(),
            Railgun::get(),

            HomingMissile::get(),
            GuidedMissile::get(),
            AiMissile::get(),

            MissileBay::get(),

            CatapultDeck::get(),
            RadarDeck::get(),
            AiRadarDeck::get(),

            CargoHold::get(),
            Container::get(),
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
        return Robotics::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return null;
    }
}
