<?php

namespace App\UnitPlatforms\Naval;

use App\Enums\UnitCapability;
use App\Enums\UnitPlatformCategory;
use App\Technologies\Bronze\CelestialNavigation;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\Diplomacy\Emissary;
use App\UnitEquipment\Espionage\Thief;
use App\UnitEquipment\Expansion\Settler;
use App\UnitEquipment\Exploring\Scout;
use App\UnitEquipment\NavalAssault\BronzeRam;
use App\UnitEquipment\NavalAssault\WoodRam;
use App\UnitEquipment\Trade\Trader;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Support\Collection;

class Galley extends UnitPlatformType
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
            WoodRam::get(),
            BronzeRam::get(),

            Settler::get(),
            Trader::get(),
            Emissary::get(),
            Thief::get(),
            Scout::get(),
        ]);
    }

    public function category(): UnitPlatformCategory
    {
        return UnitPlatformCategory::Naval;
    }

    public function icon(): string
    {
        return 'fa-sailboat';
    }

    /** @return Collection<int, UnitCapability> */
    public function modifiers(): Collection
    {
        return collect([UnitCapability::CanTravelOnSea]);
    }

    public function technology(): ?TechnologyType
    {
        return CelestialNavigation::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return HeavyGalley::get();
    }
}
