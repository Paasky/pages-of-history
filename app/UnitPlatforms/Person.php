<?php

namespace App\UnitPlatforms;

use App\Enums\UnitPlatformCategory;
use App\Technologies\TechnologyType;
use App\UnitArmor\Camouflage\Camouflage;
use App\UnitArmor\NoArmor;
use App\UnitArmor\Person\BodyArmor;
use App\UnitArmor\Person\BronzePlate;
use App\UnitArmor\Person\Chainmail;
use App\UnitArmor\Person\IronPlate;
use App\UnitArmor\Person\SteelPlate;
use App\UnitArmor\Person\WoodenShield;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\AntiTank\AntiTankMissile;
use App\UnitEquipment\AntiTank\AntiTankRifle;
use App\UnitEquipment\AntiTank\RocketGrenade;
use App\UnitEquipment\Building\Builder;
use App\UnitEquipment\Building\Engineer;
use App\UnitEquipment\Building\Peasant;
use App\UnitEquipment\Building\Worker;
use App\UnitEquipment\Diplomacy\Diplomat;
use App\UnitEquipment\Diplomacy\Emissary;
use App\UnitEquipment\Diplomacy\Envoy;
use App\UnitEquipment\Espionage\Courtesan;
use App\UnitEquipment\Espionage\Spy;
use App\UnitEquipment\Espionage\Thief;
use App\UnitEquipment\Expansion\Colonist;
use App\UnitEquipment\Expansion\Pioneer;
use App\UnitEquipment\Expansion\Settler;
use App\UnitEquipment\Expansion\Tribe;
use App\UnitEquipment\Exploring\Archeologist;
use App\UnitEquipment\Exploring\Explorer;
use App\UnitEquipment\Exploring\Naturalist;
use App\UnitEquipment\Exploring\Scout;
use App\UnitEquipment\Firearm\AssaultRifle;
use App\UnitEquipment\Firearm\FlintlockMusket;
use App\UnitEquipment\Firearm\LaserRifle;
use App\UnitEquipment\Firearm\RepeatingRifle;
use App\UnitEquipment\Firearm\RifleMusket;
use App\UnitEquipment\Firearm\ScopeRifle;
use App\UnitEquipment\Melee\BronzeSword;
use App\UnitEquipment\Melee\IronSword;
use App\UnitEquipment\Melee\Rapier;
use App\UnitEquipment\Melee\SteelSword;
use App\UnitEquipment\Melee\StoneAxe;
use App\UnitEquipment\Ranged\Bow;
use App\UnitEquipment\Ranged\CompositeBow;
use App\UnitEquipment\Ranged\Longbow;
use App\UnitEquipment\Ranged\Sling;
use App\UnitEquipment\Skirmish\BronzeThrowingSpear;
use App\UnitEquipment\Skirmish\Crossbow;
use App\UnitEquipment\Skirmish\IronThrowingSpear;
use App\UnitEquipment\Skirmish\WoodThrowingSpear;
use App\UnitEquipment\SkirmishFirearm\AiGuidedMortar;
use App\UnitEquipment\SkirmishFirearm\Arquebus;
use App\UnitEquipment\SkirmishFirearm\FlintlockCarbine;
use App\UnitEquipment\SkirmishFirearm\GuidedMortar;
use App\UnitEquipment\SkirmishFirearm\MachineGun;
use App\UnitEquipment\SkirmishFirearm\Mortar;
use App\UnitEquipment\SkirmishFirearm\RifleCarbine;
use App\UnitEquipment\Spear\BronzeSpear;
use App\UnitEquipment\Spear\Grenadier;
use App\UnitEquipment\Spear\Halberd;
use App\UnitEquipment\Spear\IronSpear;
use App\UnitEquipment\Spear\Lance;
use App\UnitEquipment\Spear\Pike;
use App\UnitEquipment\Spear\WoodSpear;
use App\UnitEquipment\Trade\Merchant;
use App\UnitEquipment\Trade\Trader;
use App\UnitEquipment\UnitEquipmentType;
use Illuminate\Support\Collection;

class Person extends UnitPlatformType
{
    public int $equipmentSlots = 2;
    public int $armorSlots = 1;
    public int $maxWeight = 2;
    public int $moves = 2;

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
            Camouflage::get(),
            BodyArmor::get(),
        ]);
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function equipment(): Collection
    {
        return collect([
            Worker::get(),
            Builder::get(),
            Peasant::get(),
            Engineer::get(),

            Tribe::get(),
            Settler::get(),
            Colonist::get(),
            Pioneer::get(),

            Thief::get(),
            Courtesan::get(),
            Spy::get(),
            Emissary::get(),
            Envoy::get(),
            Diplomat::get(),

            Trader::get(),
            Merchant::get(),

            Scout::get(),
            Explorer::get(),
            Naturalist::get(),
            Archeologist::get(),

            StoneAxe::get(),
            BronzeSword::get(),
            IronSword::get(),
            SteelSword::get(),
            Rapier::get(),

            FlintlockMusket::get(),
            RifleMusket::get(),
            RepeatingRifle::get(),
            AssaultRifle::get(),
            ScopeRifle::get(),
            LaserRifle::get(),

            WoodSpear::get(),
            BronzeSpear::get(),
            IronSpear::get(),
            Lance::get(),
            Halberd::get(),
            Pike::get(),
            Grenadier::get(),

            WoodThrowingSpear::get(),
            BronzeThrowingSpear::get(),
            IronThrowingSpear::get(),
            Crossbow::get(),

            Arquebus::get(),
            FlintlockCarbine::get(),
            RifleCarbine::get(),
            MachineGun::get(),
            Mortar::get(),
            GuidedMortar::get(),
            AiGuidedMortar::get(),

            Sling::get(),
            Bow::get(),
            CompositeBow::get(),
            Longbow::get(),

            AntiTankRifle::get(),
            RocketGrenade::get(),
            AntiTankMissile::get(),
        ]);
    }

    public function category(): UnitPlatformCategory
    {
        return UnitPlatformCategory::Foot;
    }

    public function technology(): ?TechnologyType
    {
        return null;
    }

    public function upgradesTo(): ?UnitPlatformType
    {
        return null;
    }

    public function icon(): string
    {
        return 'fa-person';
    }
}
