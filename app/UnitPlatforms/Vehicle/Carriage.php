<?php

namespace App\UnitPlatforms\Vehicle;

use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\Technologies\Bronze\Sieging;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\AntiAir\AntiAirGun;
use App\UnitEquipment\AntiAir\AntiAirLaser;
use App\UnitEquipment\AntiAir\GuidedMissile;
use App\UnitEquipment\AntiAir\HomingMissile;
use App\UnitEquipment\AntiTankGun\AntiTankGun;
use App\UnitEquipment\AntiTankGun\HighVelocityGun;
use App\UnitEquipment\Artillery\Artillery;
use App\UnitEquipment\Artillery\Howitzer;
use App\UnitEquipment\Cannon\Bombard;
use App\UnitEquipment\Cannon\Cannon;
use App\UnitEquipment\MassDestruction\AtomBomb;
use App\UnitEquipment\MassDestruction\DiseaseCatapult;
use App\UnitEquipment\MassDestruction\GasBomb;
use App\UnitEquipment\MassDestruction\VirusBomb;
use App\UnitEquipment\RocketArtillery\RocketArtillery;
use App\UnitEquipment\Siege\BatteringRam;
use App\UnitEquipment\Siege\Catapult;
use App\UnitEquipment\Siege\Onager;
use App\UnitEquipment\Siege\Trebuchet;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Carriage extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 0;
    public int $maxWeight = 2;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect();
    }

    public function category(): UnitPlatformCategory
    {
        return UnitPlatformCategory::Vehicle;
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            BatteringRam::get(),
            Catapult::get(),
            Onager::get(),
            Trebuchet::get(),

            Bombard::get(),
            Cannon::get(),
            Artillery::get(),
            Howitzer::get(),
            RocketArtillery::get(),

            AntiAirGun::get(),
            HomingMissile::get(),
            GuidedMissile::get(),
            AntiAirLaser::get(),

            AntiTankGun::get(),
            HighVelocityGun::get(),

            DiseaseCatapult::get(),
            GasBomb::get(),
            AtomBomb::get(),
            VirusBomb::get(),
        ]);
    }

    public function icon(): string
    {
        return 'fa-inbox';
    }

    public function technology(): ?TechnologyType
    {
        return Sieging::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return Tracked::get();
    }

    /** @return Collection<int, YieldModifier|YieldModifiersFor> */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Cost, percent: 25),
            new YieldModifier($this, YieldType::Defense, percent: -50)
        ]);
    }
}
