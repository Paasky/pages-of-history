<?php

namespace App\UnitPlatforms\Mounted;

use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\Resources\ResourceType;
use App\Resources\Strategic\Horses;
use App\Technologies\Bronze\Wheel;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\Ranged\Bow;
use App\UnitEquipment\Ranged\Sling;
use App\UnitEquipment\Skirmish\BronzeThrowingSpear;
use App\UnitEquipment\Skirmish\WoodThrowingSpear;
use App\UnitEquipment\Spear\BronzeSpear;
use App\UnitEquipment\Spear\WoodSpear;
use App\UnitEquipment\Trade\Trader;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

class Chariot extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 0;
    public int $maxWeight = 2;
    public int $moves = 3;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect();
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            WoodSpear::get(),
            BronzeSpear::get(),
            WoodThrowingSpear::get(),
            BronzeThrowingSpear::get(),
            Sling::get(),
            Bow::get(),

            Trader::get(),
        ]);
    }

    public function category(): UnitPlatformCategory
    {
        return UnitPlatformCategory::Mounted;
    }

    public function icon(): string
    {
        return 'fa-horse';
    }

    /**
     * @return Collection<int, ResourceType>
     */
    public function resources(): Collection
    {
        return collect([Horses::get()]);
    }

    public function technology(): ?TechnologyType
    {
        return Wheel::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return Horseback::get();
    }

    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier($this, YieldType::Cost, percent: 50),
            new YieldModifier($this, YieldType::Moves, 3),
        ]);
    }
}
