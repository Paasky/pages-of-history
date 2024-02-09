<?php

namespace App\UnitPlatforms\Vehicle;

use App\Enums\UnitPlatformCategory;
use App\Resources\ResourceType;
use App\Resources\Strategic\Oil;
use App\Technologies\Modern\AssemblyLine;
use App\Technologies\TechnologyType;
use App\UnitArmor\NoArmor;
use App\UnitArmor\UnitArmorType;
use App\UnitArmor\Vehicle\CompositeArmor;
use App\UnitArmor\Vehicle\HeavyArmor;
use App\UnitArmor\Vehicle\PointDefense;
use App\UnitArmor\Vehicle\SteelArmor;
use App\UnitEquipment\AntiTankGun\AntiTankGun;
use App\UnitEquipment\AntiTankGun\HighVelocityGun;
use App\UnitEquipment\AntiTankGun\SmoothBoreGun;
use App\UnitEquipment\Artillery\Howitzer;
use App\UnitEquipment\Building\Excavator;
use App\UnitEquipment\Building\Tractor;
use App\UnitEquipment\EnergyWeapon\Railgun;
use App\UnitEquipment\RocketArtillery\AiRocketSystem;
use App\UnitEquipment\RocketArtillery\RocketArtillery;
use App\UnitEquipment\RocketArtillery\RocketSystem;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Support\Collection;

class Tracked extends UnitPlatformType
{
    public int $equipmentSlots = 3;
    public int $armorSlots = 1;
    public int $maxWeight = 3;
    public int $moves = 3;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect([
            NoArmor::get(),
            SteelArmor::get(),
            HeavyArmor::get(),
            CompositeArmor::get(),
            PointDefense::get(),
        ]);
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            Tractor::get(),
            Excavator::get(),

            Howitzer::get(),
            RocketArtillery::get(),
            RocketSystem::get(),
            AiRocketSystem::get(),

            AntiTankGun::get(),
            HighVelocityGun::get(),
            SmoothBoreGun::get(),
            Railgun::get(),
        ]);
    }

    public function category(): UnitPlatformCategory
    {
        return UnitPlatformCategory::Vehicle;
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
        return AssemblyLine::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return null;
    }

    public function icon(): string
    {
        return 'fa-compress';
    }
}
