<?php

namespace App\UnitPlatforms\Naval;

use App\Enums\UnitPlatformCategory;
use App\Technologies\Copper\Sailing;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\Diplomacy\Emissary;
use App\UnitEquipment\Espionage\Thief;
use App\UnitEquipment\Expansion\Settler;
use App\UnitEquipment\Expansion\Tribe;
use App\UnitEquipment\Exploring\Scout;
use App\UnitEquipment\Trade\Trader;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Support\Collection;

class Raft extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 0;
    public int $maxWeight = 2;
    public int $moves = 2;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect();
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            Tribe::get(),
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

    public function technology(): ?TechnologyType
    {
        return Sailing::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return Galley::get();
    }
}
