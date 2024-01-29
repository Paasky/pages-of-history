<?php

namespace App\UnitPlatforms\Mounted;

use App\Enums\UnitPlatformCategory;
use App\Resources\ResourceType;
use App\Resources\Strategic\Horses;
use App\Technologies\Medieval\Stirrup;
use App\Technologies\TechnologyType;
use App\UnitArmor\NoArmor;
use App\UnitArmor\Person\BronzePlate;
use App\UnitArmor\Person\Chainmail;
use App\UnitArmor\Person\IronPlate;
use App\UnitArmor\Person\SteelPlate;
use App\UnitArmor\Person\WoodenShield;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\Diplomacy\Diplomat;
use App\UnitEquipment\Diplomacy\Emissary;
use App\UnitEquipment\Espionage\Courtesan;
use App\UnitEquipment\Espionage\Spy;
use App\UnitEquipment\Espionage\Thief;
use App\UnitEquipment\Expansion\Colonist;
use App\UnitEquipment\Expansion\Pioneer;
use App\UnitEquipment\Exploring\Archeologist;
use App\UnitEquipment\Exploring\Explorer;
use App\UnitEquipment\Exploring\Naturalist;
use App\UnitEquipment\Exploring\Scout;
use App\UnitEquipment\Melee\IronSword;
use App\UnitEquipment\Melee\Rapier;
use App\UnitEquipment\Melee\SteelSword;
use App\UnitEquipment\Ranged\Bow;
use App\UnitEquipment\Ranged\CompositeBow;
use App\UnitEquipment\Skirmish\IronThrowingSpear;
use App\UnitEquipment\SkirmishFirearm\FlintlockCarbine;
use App\UnitEquipment\SkirmishFirearm\RifleCarbine;
use App\UnitEquipment\Spear\Grenadier;
use App\UnitEquipment\Spear\IronSpear;
use App\UnitEquipment\Spear\Lance;
use App\UnitEquipment\Spear\Pike;
use App\UnitEquipment\Trade\Merchant;
use App\UnitEquipment\Trade\Trader;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use App\UnitPlatforms\Vehicle\Wheeled;
use Illuminate\Support\Collection;

class SaddledHorse extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 1;
    public int $maxWeight = 3;
    public int $moves = 3;

    /** @return Collection<int, UnitArmorType> */
    public function armors(): Collection
    {
        return collect([
            NoArmor::get(),

            WoodenShield::get(),
            BronzePlate::get(),
            IronPlate::get(),
            Chainmail::get(),
            SteelPlate::get(),
        ]);
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            Colonist::get(),
            Pioneer::get(),

            Thief::get(),
            Courtesan::get(),
            Spy::get(),
            Emissary::get(),
            Diplomat::get(),

            Scout::get(),
            Explorer::get(),
            Naturalist::get(),
            Archeologist::get(),

            Trader::get(),
            Merchant::get(),

            IronSword::get(),
            SteelSword::get(),
            Rapier::get(),

            IronSpear::get(),
            Lance::get(),
            Pike::get(),
            Grenadier::get(),

            IronThrowingSpear::get(),

            FlintlockCarbine::get(),
            RifleCarbine::get(),

            Bow::get(),
            CompositeBow::get(),
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
        return Stirrup::get();
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return Wheeled::get();
    }

    public function icon(): string
    {
        return 'fa-horse';
    }
}
