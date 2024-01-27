<?php

namespace App\UnitPlatforms\Vehicle;

use App\Enums\UnitPlatformCategory;
use App\Technologies\Bronze\Sieging;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\AntiAir\AiMissile;
use App\UnitEquipment\AntiAir\AntiAirGun;
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
use App\UnitEquipment\Siege\Catapult;
use App\UnitEquipment\Siege\Onager;
use App\UnitEquipment\Siege\Ram;
use App\UnitEquipment\Siege\Trebuchet;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Support\Collection;

class Carriage extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 0;
    public int $maxWeight = 2;
    public int $moves = 2;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect();
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            Ram::get(),
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
            AiMissile::get(),

            AntiTankGun::get(),
            HighVelocityGun::get(),

            DiseaseCatapult::get(),
            GasBomb::get(),
            AtomBomb::get(),
            VirusBomb::get(),
        ]);
    }

    public function category(): UnitPlatformCategory
    {
        return UnitPlatformCategory::Vehicle;
    }

    public function technology(): ?TechnologyType
    {
        return Sieging::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return Tracked::get();
    }

    public function icon(): string
    {
        return 'fa-inbox';
    }
}
