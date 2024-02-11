<?php

namespace App\UnitPlatforms\Air;

use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\Resources\ResourceType;
use App\Resources\Strategic\Oil;
use App\Technologies\Digital\Microchips;
use App\Technologies\TechnologyType;
use App\UnitArmor\Air\ChaffFlare;
use App\UnitArmor\Air\RadarJamming;
use App\UnitArmor\Stealth\AdvancedStealth;
use App\UnitArmor\Stealth\Stealth;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\Bomb\AiGuidedBomb;
use App\UnitEquipment\Bomb\GuidedBomb;
use App\UnitEquipment\Bomb\HeavyBomb;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class AttackHelicopter extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 1;
    public int $maxWeight = 3;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect([
            ChaffFlare::get(),
            RadarJamming::get(),

            Stealth::get(),
            AdvancedStealth::get(),
        ]);
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            HeavyBomb::get(),
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
        return 'fa-helicopter';
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
        return Microchips::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return null;
    }

    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier(YieldType::Cost, percent: 40),
            new YieldModifier(YieldType::Agility, 5),
            new YieldModifier(YieldType::Moves, 2),
            new YieldModifier(YieldType::Range, 6),
        ]);
    }
}
