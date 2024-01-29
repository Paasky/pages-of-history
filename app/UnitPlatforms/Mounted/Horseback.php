<?php

namespace App\UnitPlatforms\Mounted;

use App\Enums\UnitPlatformCategory;
use App\Resources\ResourceType;
use App\Resources\Strategic\Horses;
use App\Technologies\Iron\HorsebackRiding;
use App\Technologies\TechnologyType;
use App\UnitArmor\NoArmor;
use App\UnitArmor\Person\BronzePlate;
use App\UnitArmor\Person\IronPlate;
use App\UnitArmor\Person\WoodenShield;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\Diplomacy\Emissary;
use App\UnitEquipment\Espionage\Thief;
use App\UnitEquipment\Exploring\Scout;
use App\UnitEquipment\Melee\BronzeSword;
use App\UnitEquipment\Melee\IronSword;
use App\UnitEquipment\Melee\StoneAxe;
use App\UnitEquipment\Ranged\Bow;
use App\UnitEquipment\Skirmish\BronzeThrowingSpear;
use App\UnitEquipment\Skirmish\IronThrowingSpear;
use App\UnitEquipment\Skirmish\WoodThrowingSpear;
use App\UnitEquipment\Spear\BronzeSpear;
use App\UnitEquipment\Spear\IronSpear;
use App\UnitEquipment\Spear\WoodSpear;
use App\UnitEquipment\Trade\Merchant;
use App\UnitEquipment\Trade\Trader;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Support\Collection;

class Horseback extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 1;
    public int $maxWeight = 2;
    public int $moves = 3;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect([
            NoArmor::get(),

            WoodenShield::get(),
            BronzePlate::get(),
            IronPlate::get(),
        ]);
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            Thief::get(),
            Emissary::get(),

            StoneAxe::get(),
            BronzeSword::get(),
            IronSword::get(),
            WoodSpear::get(),
            BronzeSpear::get(),
            IronSpear::get(),
            WoodThrowingSpear::get(),
            BronzeThrowingSpear::get(),
            IronThrowingSpear::get(),
            Bow::get(),

            Trader::get(),
            Merchant::get(),

            Scout::get(),
        ]);
    }

    public function category(): UnitPlatformCategory
    {
        return UnitPlatformCategory::Mounted;
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
        return HorsebackRiding::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return SaddledHorse::get();
    }

    public function icon(): string
    {
        return 'fa-horse';
    }
}
