<?php

namespace App\UnitPlatforms\Air;

use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\Resources\ResourceType;
use App\Resources\Strategic\Oil;
use App\Technologies\Modern\MetalAlloys;
use App\Technologies\TechnologyType;
use App\UnitArmor\Air\SealingTanks;
use App\UnitArmor\NoArmor;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\AirGun\AirMachineGun;
use App\UnitEquipment\Bomb\HeavyBomb;
use App\UnitEquipment\Bomb\LightBomb;
use App\UnitEquipment\MassDestruction\AtomBomb;
use App\UnitEquipment\MassDestruction\GasBomb;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class Monocoque extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 1;
    public int $maxWeight = 2;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect([
            NoArmor::get(),
            SealingTanks::get(),
        ]);
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            AirMachineGun::get(),

            LightBomb::get(),
            HeavyBomb::get(),

            GasBomb::get(),
            AtomBomb::get(),
        ]);
    }

    public function category(): UnitPlatformCategory
    {
        return UnitPlatformCategory::Air;
    }

    public function icon(): string
    {
        return 'fa-plane';
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
        return MetalAlloys::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return Supersonic::get();
    }

    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Cost, percent: 15),
            new YieldModifier($this, YieldType::Agility, 3),
            new YieldModifier($this, YieldType::Moves, 1),
            new YieldModifier($this, YieldType::Range, 6),
        ]);
    }
}
