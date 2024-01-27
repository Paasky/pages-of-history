<?php

namespace App\UnitPlatforms\Vehicle;

use App\Enums\UnitPlatformCategory;
use App\Resources\ResourceType;
use App\Resources\Strategic\Oil;
use App\Technologies\Modern\AssemblyLine;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\UnitArmor\Vehicle\ActiveDefense;
use App\UnitArmor\Vehicle\CompositeArmor;
use App\UnitArmor\Vehicle\HeavyArmor;
use App\UnitArmor\Vehicle\SteelArmor;
use App\UnitEquipment\AntiAir\AiMissile;
use App\UnitEquipment\AntiAir\AntiAirGun;
use App\UnitEquipment\AntiAir\GuidedMissile;
use App\UnitEquipment\AntiAir\HomingMissile;
use App\UnitEquipment\AntiTankGun\AntiTankGun;
use App\UnitEquipment\AntiTankGun\HighVelocityGun;
use App\UnitEquipment\AntiTankGun\SmoothBoreGun;
use App\UnitEquipment\Artillery\Artillery;
use App\UnitEquipment\Artillery\Howitzer;
use App\UnitEquipment\Building\Excavator;
use App\UnitEquipment\Building\Tractor;
use App\UnitEquipment\RocketArtillery\AiRocketSystem;
use App\UnitEquipment\RocketArtillery\RocketArtillery;
use App\UnitEquipment\RocketArtillery\RocketSystem;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Support\Collection;

class Tracked extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 2;
    public int $maxWeight = 4;
    public int $moves = 4;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect([
            SteelArmor::get(),
            HeavyArmor::get(),
            CompositeArmor::get(),
            ActiveDefense::get(),
        ]);
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            Tractor::get(),
            Excavator::get(),

            Artillery::get(),
            Howitzer::get(),
            RocketArtillery::get(),
            RocketSystem::get(),
            AiRocketSystem::get(),
            AntiAirGun::get(),
            HomingMissile::get(),
            GuidedMissile::get(),
            AiMissile::get(),
            AntiTankGun::get(),
            HighVelocityGun::get(),
            SmoothBoreGun::get(),
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
