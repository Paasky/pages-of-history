<?php

namespace App\UnitPlatforms\Air;

use App\UnitArmor\Air\RadarJamming;
use App\UnitArmor\UnitArmorType;
use App\UnitArmor\Stealth\AdvancedStealth;
use App\UnitArmor\Stealth\Stealth;
use App\Enums\UnitPlatformCategory;
use App\UnitPlatforms\UnitPlatformType;
use App\Resources\ResourceType;
use App\Resources\Strategic\Oil;
use App\Technologies\Information\Graphene;
use App\Technologies\TechnologyType;
use App\UnitEquipment\AirGun\AirAiMissile;
use App\UnitEquipment\AirGun\AirGuidedMissile;
use App\UnitEquipment\Bomb\AiGuidedBomb;
use App\UnitEquipment\Bomb\GuidedBomb;
use App\UnitEquipment\MassDestruction\AtomBomb;
use App\UnitEquipment\MassDestruction\GasBomb;
use App\UnitEquipment\MassDestruction\HydrogenBomb;
use App\UnitEquipment\MassDestruction\VirusBomb;
use App\UnitEquipment\UnitEquipmentType;
use Illuminate\Support\Collection;

class Supermanouverable extends UnitPlatformType
{
    public int $equipmentSlots = 1;
    public int $armorSlots = 1;
    public int $maxWeight = 2;
    public int $moves = 1;
    public int $range = 8;
    public int $maneuvering = 10;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect([
            RadarJamming::get(),

            Stealth::get(),
            AdvancedStealth::get(),

            GasBomb::get(),
            AtomBomb::get(),
            HydrogenBomb::get(),
            VirusBomb::get(),
        ]);
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            AirGuidedMissile::get(),
            AirAiMissile::get(),

            GuidedBomb::get(),
            AiGuidedBomb::get(),
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
        return Graphene::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return null;
    }
}
