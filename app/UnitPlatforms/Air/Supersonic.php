<?php

namespace App\UnitPlatforms\Air;

use App\UnitArmor\Air\ChaffFlare;
use App\UnitArmor\Air\SealingTanks;
use App\UnitArmor\UnitArmorType;
use App\Enums\UnitPlatformCategory;
use App\UnitPlatforms\UnitPlatformType;
use App\Resources\ResourceType;
use App\Resources\Strategic\Oil;
use App\Technologies\Atomic\OrbitalBallistics;
use App\Technologies\TechnologyType;
use App\UnitEquipment\AirGun\AirGuidedMissile;
use App\UnitEquipment\AirGun\AirHomingMissile;
use App\UnitEquipment\AirGun\AirMachineGun;
use App\UnitEquipment\Bomb\GuidedBomb;
use App\UnitEquipment\Bomb\HeavyBomb;
use App\UnitEquipment\MassDestruction\AtomBomb;
use App\UnitEquipment\MassDestruction\GasBomb;
use App\UnitEquipment\MassDestruction\HydrogenBomb;
use App\UnitEquipment\MassDestruction\VirusBomb;
use App\UnitEquipment\UnitEquipmentType;
use Illuminate\Support\Collection;

class Supersonic extends UnitPlatformType
{
    public int $equipmentSlots = 1;
    public int $armorSlots = 1;
    public int $maxWeight = 2;
    public int $moves = 1;
    public int $range = 6;
    public int $maneuvering = 5;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect([
            SealingTanks::get(),
            ChaffFlare::get(),
        ]);
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            AirMachineGun::get(),
            AirHomingMissile::get(),
            AirGuidedMissile::get(),

            HeavyBomb::get(),
            GuidedBomb::get(),

            GasBomb::get(),
            AtomBomb::get(),
            HydrogenBomb::get(),
            VirusBomb::get(),
        ]);
    }

    public function category(): UnitPlatformCategory
    {
        return UnitPlatformCategory::Air;
    }

    public function icon(): string
    {
        return 'fa-jet-fighter';
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
        return OrbitalBallistics::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return FlyByWire::get();
    }
}
