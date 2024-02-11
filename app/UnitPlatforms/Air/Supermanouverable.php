<?php

namespace App\UnitPlatforms\Air;

use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\Resources\ResourceType;
use App\Resources\Strategic\Oil;
use App\Technologies\Information\Graphene;
use App\Technologies\TechnologyType;
use App\UnitArmor\Air\RadarJamming;
use App\UnitArmor\Stealth\AdvancedStealth;
use App\UnitArmor\Stealth\Stealth;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\AirGun\AirAiMissile;
use App\UnitEquipment\AirGun\AirGuidedMissile;
use App\UnitEquipment\Bomb\AiGuidedBomb;
use App\UnitEquipment\Bomb\GuidedBomb;
use App\UnitEquipment\MassDestruction\AtomBomb;
use App\UnitEquipment\MassDestruction\HydrogenBomb;
use App\UnitEquipment\MassDestruction\VirusBomb;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class Supermanouverable extends UnitPlatformType
{
    public int $equipmentSlots = 1;
    public int $armorSlots = 1;
    public int $maxWeight = 2;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect([
            RadarJamming::get(),
            Stealth::get(),
            AdvancedStealth::get(),
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
        return Graphene::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return null;
    }

    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier(YieldType::Cost, percent: 60),
            new YieldModifier(YieldType::Agility, 10),
            new YieldModifier(YieldType::Moves, 1),
            new YieldModifier(YieldType::Range, 8),
        ]);
    }
}
