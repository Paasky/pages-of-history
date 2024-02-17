<?php

namespace App\UnitPlatforms\Naval;

use App\Enums\UnitCapability;
use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\Technologies\Atomic\Robotics;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\UnitArmor\Vehicle\CompositeArmor;
use App\UnitArmor\Vehicle\HeavyArmor;
use App\UnitArmor\Vehicle\PointDefense;
use App\UnitEquipment\Artillery\Howitzer;
use App\UnitEquipment\EnergyWeapon\Railgun;
use App\UnitEquipment\FlightDeck\AiRadarDeck;
use App\UnitEquipment\FlightDeck\CatapultDeck;
use App\UnitEquipment\FlightDeck\RadarDeck;
use App\UnitEquipment\RocketArtillery\AiRocketSystem;
use App\UnitEquipment\RocketArtillery\RocketSystem;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class NuclearEngine extends UnitPlatformType
{
    public int $equipmentSlots = 3;
    public int $armorSlots = 1;
    public int $maxWeight = 4;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect([
            HeavyArmor::get(),
            CompositeArmor::get(),
            PointDefense::get(),
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
        return Robotics::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return null;
    }

    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Cost, percent: 100),
            new YieldModifier($this, YieldType::Moves, 7),
        ]);
    }
}
