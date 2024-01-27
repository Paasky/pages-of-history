<?php

namespace App\UnitPlatforms\Air;

use App\Enums\UnitPlatformCategory;
use App\Resources\ResourceType;
use App\Resources\Strategic\Oil;
use App\Technologies\Modern\JetEngine;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\Bomb\GuidedBomb;
use App\UnitEquipment\Bomb\HeavyBomb;
use App\UnitEquipment\Bomb\LightBomb;
use App\UnitEquipment\MassDestruction\AtomBomb;
use App\UnitEquipment\MassDestruction\GasBomb;
use App\UnitEquipment\MassDestruction\VirusBomb;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Support\Collection;

class CruiseMissile extends UnitPlatformType
{
    public int $equipmentSlots = 1;
    public int $armorSlots = 0;
    public int $maxWeight = 1;
    public int $moves = 1;
    public int $range = 6;
    public int $maneuvering = 5;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect();
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            LightBomb::get(),
            HeavyBomb::get(),
            GuidedBomb::get(),

            GasBomb::get(),
            AtomBomb::get(),
            VirusBomb::get(),
        ]);
    }

    public function category(): UnitPlatformCategory
    {
        return UnitPlatformCategory::Air;
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
        return JetEngine::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return HypersonicMissile::get();
    }

    public function icon(): string
    {
        return 'fa-rocket';
    }
}
