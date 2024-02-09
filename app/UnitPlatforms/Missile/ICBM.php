<?php

namespace App\UnitPlatforms\Missile;

use App\Enums\UnitPlatformCategory;
use App\Resources\ResourceType;
use App\Resources\Strategic\Oil;
use App\Technologies\Atomic\Satellites;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\Bomb\AiGuidedBomb;
use App\UnitEquipment\Bomb\GuidedBomb;
use App\UnitEquipment\Bomb\HeavyBomb;
use App\UnitEquipment\MassDestruction\HydrogenBomb;
use App\UnitEquipment\MassDestruction\VirusBomb;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Support\Collection;

class ICBM extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 0;
    public int $maxWeight = 2;
    public int $moves = 1;
    public int $range = -1;
    public int $maneuvering = 15;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect();
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            HeavyBomb::get(),
            GuidedBomb::get(),
            AiGuidedBomb::get(),
            HydrogenBomb::get(),
            VirusBomb::get(),
        ]);
    }

    public function category(): UnitPlatformCategory
    {
        return UnitPlatformCategory::Missile;
    }

    public function name(): string
    {
        return 'ICBM';
    }

    /**
     * @return Collection<int, ResourceType>
     */
    public function resources(): Collection
    {
        return collect([Oil::get()]);
    }

    public function shortName(): string
    {
        return 'ICBM';
    }

    public function technology(): ?TechnologyType
    {
        return Satellites::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return null;
    }

    public function icon(): string
    {
        return 'fa-rocket';
    }
}
