<?php

namespace App\Enums;

use App\GameConcept;
use App\UnitEquipment\UnitEquipmentType;
use Illuminate\Support\Collection;

enum UnitEquipmentCategory: string implements GameConcept
{
    use GameConceptEnum;
    use PohEnum;

    case Building = 'Building';
    case Exploring = 'Exploring';
    case Expansion = 'Expansion';
    case Trade = 'Trade';
    case Diplomacy = 'Diplomacy';
    case Espionage = 'Espionage';

    case Melee = 'Melee';
    case Firearm = 'Firearm';
    case Spear = 'Spear';
    case AntiTank = 'AntiTank';
    case AntiTankGun = 'AntiTankGun';
    case Skirmish = 'Skirmish';
    case SkirmishFirearm = 'SkirmishFirearm';
    case Ranged = 'Ranged';
    case Siege = 'Siege';
    case Cannon = 'Cannon';
    case Artillery = 'Artillery';
    case RocketArtillery = 'RocketArtillery';
    case Torpedo = 'Torpedo';
    case MissileBay = 'MissileBay';
    case FlightDeck = 'FlightDeck';
    case EnergyWeapon = 'EnergyWeapon';
    case AntiAir = 'AntiAir';
    case AirGun = 'AirGun';
    case Bomb = 'AirBomb';
    case MassDestruction = 'MassDestruction';

    public function icon(): string
    {
        return match ($this) {
            self::Building => 'fa-hammer',
            self::Expansion => 'fa-house-flag',
            self::Exploring => 'fa-binoculars',
            self::Trade => 'fa-basket-shopping',
            self::Diplomacy => 'fa-book',
            self::Espionage => 'fa-user-secret',
            self::Firearm => 'fa-gun',
            self::Spear => YieldType::Defense->icon(),
            self::Ranged => YieldType::Range->icon(),
            self::Cannon => 'fa-bomb',
            self::MissileBay => 'fa-arrow-up-from-water-pump',
            self::RocketArtillery => 'fa-rocket',
            self::FlightDeck => 'fa-plane-arrival',
            self::Torpedo => 'fa-water',
            self::AntiAir => 'fa-plane-slash',
            self::Siege => 'fa-arrow-right-to-city',
            self::Artillery => 'fa-crosshairs',
            self::Skirmish, self::SkirmishFirearm => 'fa-arrows-to-dot',
            self::Melee => 'fa-hand-fist',
            self::AntiTank, self::AntiTankGun => 'fa-car-burst',
            self::EnergyWeapon => 'fa-burst',
            default => $this->class()->icon(),
        };
    }

    public function class(): UnitEquipmentClass
    {
        return match ($this) {
            self::Building, self::Expansion, self::Trade,
            self::Diplomacy, self::Espionage, self::Exploring => UnitEquipmentClass::NonCombat,

            self::Melee, self::Firearm, self::Spear, self::AntiTank, self::AntiTankGun
            => UnitEquipmentClass::CloseCombat,

            self::Skirmish, self::SkirmishFirearm, self::Ranged, self::Siege,
            self::Cannon, self::Artillery, self::RocketArtillery,
            self::Torpedo, self::EnergyWeapon,
            => UnitEquipmentClass::Ranged,

            self::AntiAir, self::MissileBay, self::FlightDeck
            => UnitEquipmentClass::Support,

            self::AirGun
            => UnitEquipmentClass::Aerial,

            self::Bomb
            => UnitEquipmentClass::Bomb,

            self::MassDestruction
            => UnitEquipmentClass::MassDestruction,
        };
    }

    /** @return Collection<int, GameConcept> */
    public function items(): Collection
    {
        return UnitEquipmentType::all()->filter(
            fn(UnitEquipmentType $type) => $type->category() === $this
        );
    }

    /** @return Collection<int, UnitPlatformCategory> */
    public function platformCategories(): Collection
    {
        return match ($this) {
            self::Melee, self::Firearm,
            self::Spear, self::AntiTank,
            self::Skirmish, self::SkirmishFirearm,
            self::Ranged => collect([
                UnitPlatformCategory::Foot,
                UnitPlatformCategory::Mounted,
            ]),
            self::AntiTankGun => collect([
                UnitPlatformCategory::Vehicle,
            ]),
            self::Siege, self::Cannon,
            self::Artillery, self::RocketArtillery,
            self::AntiAir => collect([
                UnitPlatformCategory::Vehicle,
                UnitPlatformCategory::Naval,
            ]),
            self::EnergyWeapon => collect([
                UnitPlatformCategory::Vehicle,
                UnitPlatformCategory::Naval,
                UnitPlatformCategory::Space,
            ]),
            self::Torpedo, self::MissileBay, self::FlightDeck => collect([
                UnitPlatformCategory::Naval,
            ]),
            self::AirGun, self::Bomb, self::MassDestruction => collect([
                UnitPlatformCategory::Air,
            ]),
            self::Building => collect([
                UnitPlatformCategory::Foot,
                UnitPlatformCategory::Vehicle,
            ]),
            self::Expansion, self::Trade,
            self::Diplomacy, self::Espionage => collect([
                UnitPlatformCategory::Foot,
                UnitPlatformCategory::Mounted,
                UnitPlatformCategory::Naval,
            ]),
        };
    }

    public function typeSlug(): string
    {
        return $this->class()->typeSlug();
    }

    public function weight(): int
    {
        return match ($this) {
            self::Melee, self::Firearm, self::Torpedo, self::MissileBay,
            self::AirGun, self::Bomb, self::MassDestruction => 1,

            self::Spear, self::Ranged,
            self::FlightDeck, self::AntiAir,
            self::Siege, self::Cannon, self::Artillery, self::RocketArtillery,
            self::Skirmish, self::SkirmishFirearm,
            self::AntiTank, self::AntiTankGun => 2,

            self::EnergyWeapon => 3,
        };
    }
}
