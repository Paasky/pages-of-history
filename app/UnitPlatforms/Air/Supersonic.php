<?php

namespace App\UnitPlatforms\Air;

use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\Resources\ResourceType;
use App\Resources\Strategic\Oil;
use App\Technologies\Atomic\OrbitalBallistics;
use App\Technologies\TechnologyType;
use App\UnitArmor\Air\ChaffFlare;
use App\UnitArmor\Air\SealingTanks;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\AirGun\AirGuidedMissile;
use App\UnitEquipment\AirGun\AirHomingMissile;
use App\UnitEquipment\Bomb\GuidedBomb;
use App\UnitEquipment\Bomb\HeavyBomb;
use App\UnitEquipment\MassDestruction\AtomBomb;
use App\UnitEquipment\MassDestruction\HydrogenBomb;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class Supersonic extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 1;
    public int $maxWeight = 3;

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
            AirHomingMissile::get(),
            AirGuidedMissile::get(),

            HeavyBomb::get(),
            GuidedBomb::get(),

            AtomBomb::get(),
            HydrogenBomb::get(),
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

    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Cost, percent: 30),
            new YieldModifier($this, YieldType::Agility, 5),
            new YieldModifier($this, YieldType::Moves, 1),
            new YieldModifier($this, YieldType::Range, 6),
        ]);
    }
}
