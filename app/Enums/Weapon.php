<?php

namespace App\Enums;

use App\Models\Unit;

enum Weapon: string
{
    use PohEnum;

    public const CostMultiplier = 5;
    public const WmdMultiplier = 5;

    case StoneAxe = 'StoneAxe';
    case BronzeSword = 'BronzeSword';
    case IronSword = 'IronSword';
    case SteelSword = 'SteelSword';
    case Arquebus = 'Arquebus';
    case Musket = 'Musket';
    case RifleMusket = 'RifleMusket';
    case RepeatingRifle = 'RepeatingRifle';
    case AssaultRifle = 'AssaultRifle';
    case ScopeRifle = 'ScopeRifle';
    case LaserRifle = 'LaserRifle';

    case WoodSpear = 'WoodSpear';
    case BronzeSpear = 'BronzeSpear';
    case IronSpear = 'IronSpear';
    case Lance = 'Lance';
    case Halberd = 'Halberd';
    case Pike = 'Pike';
    case Grenadier = 'Grenadier';
    case AntiTankRifle = 'AntiTankRifle';
    case RocketGrenade = 'RocketGrenade';
    case AntiTankMissile = 'AntiTankMissile';

    case WoodThrowingSpear = 'WoodThrowingSpear';
    case BronzeThrowingSpear = 'BronzeThrowingSpear';
    case IronThrowingSpear = 'IronThrowingSpear';
    case Crossbow = 'Crossbow';
    case MachineGun = 'MachineGun';

    case Sling = 'Sling';
    case Bow = 'Bow';
    case CompositeBow = 'CompositeBow';
    case Longbow = 'Longbow';
    case Mortar = 'Mortar';

    case Ram = 'Ram';
    case Catapult = 'Catapult';
    case Onager = 'Onager';
    case Trebuchet = 'Trebuchet';
    case Bombard = 'Bombard';
    case Cannon = 'Cannon';
    case Artillery = 'Artillery';
    case Howitzer = 'Howitzer';
    case RocketArtillery = 'RocketArtillery';
    case RocketSystem = 'RocketSystem';

    case AntiTankGun = 'AntiTankGun';
    case HighVelocityGun = 'HighVelocityGun';
    case SmoothBoreGun = 'SmoothBoreGun';
    case Railgun = 'Railgun';

    case AntiAirGun = 'AntiAirGun';
    case HomingMissile = 'HomingMissile';
    case GuidedMissile = 'GuidedMissile';
    case AiMissile = 'AiMissile';

    case AirMachineGun = 'AirMachineGun';
    case AirHomingMissile = 'AirHomingMissile';
    case AirGuidedMissile = 'AirGuidedMissile';
    case AirAiMissile = 'AirAiMissile';
    case LightBomb = 'LightBomb';
    case HeavyBomb = 'HeavyBomb';
    case GuidedBomb = 'GuidedBomb';

    case Torpedo = 'Torpedo';
    case HomingTorpedo = 'HomingTorpedo';
    case GuidedTorpedo = 'GuidedTorpedo';
    case AiTorpedo = 'AiTorpedo';

    case WoodenDeck = 'WoodenDeck';
    case CatapultDeck = 'CatapultDeck';
    case RadarDeck = 'RadarDeck';
    case MissileBay = 'MissileBay';

    case GasBomb = 'GasBomb';
    case AtomBomb = 'AtomBomb';
    case HydrogenBomb = 'HydrogenBomb';

    public function category(): WeaponCategory
    {
        return $this->type()->category();
    }

    public function cost(): int
    {
        $cost = $this->strength() * Weapon::CostMultiplier;
        if ($this->type()->is(WeaponType::MassDestruction)) {
            return $cost * Weapon::WmdMultiplier;
        }
        return $cost;
    }

    public function era(): Era
    {
        return match ($this) {
            self::StoneAxe, self::WoodSpear, self::WoodThrowingSpear, self::Sling, self::Ram,
            => Era::Ancient,

            self::BronzeSword, self::BronzeSpear, self::BronzeThrowingSpear, self::Bow, self::Catapult,
            => Era::Bronze,

            self::IronSword, self::IronSpear, self::IronThrowingSpear, self::CompositeBow, self::Onager,
            => Era::Iron,

            self::SteelSword, self::Lance, self::Longbow, self::Crossbow, self::Trebuchet,
            => Era::Medieval,

            self::Arquebus, self::Halberd, self::Bombard,
            => Era::Renaissance,

            self::Musket, self::Pike, self::Cannon,
            => Era::Enlightenment,

            self::RifleMusket, self::Grenadier, self::Artillery
            => Era::Industrial,

            self::RepeatingRifle, self::AntiTankRifle, self::AntiTankGun, self::AntiAirGun, self::MachineGun,
            self::Mortar, self::Howitzer, self::RocketArtillery, self::AirMachineGun, self::LightBomb, self::GasBomb,
            self::Torpedo, self::WoodenDeck,
            => Era::Modern,

            self::AssaultRifle, self::RocketGrenade, self::HighVelocityGun, self::HomingMissile, self::MissileBay,
            self::AirHomingMissile, self::HeavyBomb, self::AtomBomb, self::HomingTorpedo, self::CatapultDeck,
            => Era::Atomic,

            self::ScopeRifle, self::RocketSystem, self::AntiTankMissile, self::SmoothBoreGun, self::GuidedMissile,
            self::AirGuidedMissile, self::GuidedBomb, self::HydrogenBomb, self::GuidedTorpedo, self::RadarDeck,
            => Era::Information,

            self::LaserRifle, self::Railgun, self::AiMissile, self::AirAiMissile, self::AiTorpedo,
            => Era::Cyber,
        };
    }

    public function isRanged(): bool
    {
        return $this->category()->is(
            WeaponCategory::Ranged, WeaponCategory::Aerial, WeaponCategory::Bomb, WeaponCategory::MassDestruction
        );
    }

    public function range(): int
    {
        return match ($this->type()) {
            WeaponType::Skirmish, WeaponType::Torpedo => 1,

            WeaponType::Ranged, WeaponType::Siege, WeaponType::Cannon, WeaponType::Railgun => 2,

            WeaponType::Artillery, WeaponType::RocketArtillery => 3,

            WeaponType::AirGun => $this->era()->orderNumber(),

            WeaponType::AirBomb => round($this->era()->orderNumber() * 1.5),

            default => 0,
        };
    }

    public function rangedStrength(Unit $against = null): float
    {
        if (!$this->isRanged()) {
            return 0;
        }

        $baseDamage = $this->era()->baseDamage();

        // WMD get a special buff
        if ($this->type()->is(WeaponType::MassDestruction)) {
            return round(pow($baseDamage, 1.15));
        }

        // Not against anything special, so return the base damage
        if (!$against) {
            return $baseDamage;
        }

        $modifier = 1;
        switch ($this->type()) {
            case WeaponType::Artillery:
            case WeaponType::RocketArtillery:
                if ($against->type->is(UnitType::Infantry, UnitType::HeavyInfantry)) {
                    $modifier += 0.2;
                }
                break;

            case WeaponType::Ranged:
            case WeaponType::Skirmish:
                if ($against->type->is(UnitType::HeavyInfantry)) {
                    $modifier += 0.2;
                }
                break;

            case WeaponType::Torpedo:
            case WeaponType::Railgun:
                if ($against->type->is(UnitType::Ship, UnitType::HeavyShip)) {
                    $modifier += 0.2;
                }
                break;

            case WeaponType::AirBomb:
                if ($against->type->is(UnitType::Towed, UnitType::Tracked, UnitType::Ship, UnitType::HeavyShip)) {
                    $modifier += 0.2;
                } else {
                    $modifier -= 0.2;
                }
                break;

            default:
        }

        return $baseDamage * $modifier;
    }

    public function strength(Unit $against = null): float
    {
        $baseDamage = $this->era()->baseDamage();

        // Ranged, Flight Deck & Missile Bay gets a special debuff
        if ($this->isRanged() || $this->type()->is(WeaponType::FlightDeck, WeaponType::MissileBay)) {
            return round($baseDamage * 0.75);
        }

        // Not against anything special, so return the base damage
        if (!$against) {
            return $baseDamage;
        }

        $modifier = 1;

        // Default damage vs aircraft is 0
        if ($against->type->domain()->is(Domain::Air)) {
            $modifier = 0;
        }

        switch ($this->type()) {
            case WeaponType::AntiCavalry:
                if ($against->type->is(UnitType::Mounted)) {
                    $modifier += 0.2;
                }
                break;

            case WeaponType::AntiTank:
            case WeaponType::AntiTankGun:
                if ($against->type->is(UnitType::Towed, UnitType::Tracked)) {
                    $modifier += 0.2;
                }
                break;

            case WeaponType::AntiAir:
                if ($against->type->is(UnitType::Fighter, UnitType::Bomber, UnitType::Helicopter)) {
                    $modifier += 1.0;
                }
                break;

            case WeaponType::Melee:
            case WeaponType::Firearm:
                if ($against->type->is(UnitType::Infantry, UnitType::HeavyInfantry)) {
                    $modifier += 0.2;
                }
                break;

            case WeaponType::Torpedo:
            case WeaponType::Railgun:
                if ($against->type->is(UnitType::Ship, UnitType::HeavyShip)) {
                    $modifier += 0.2;
                }
                break;

            case WeaponType::AirGun:
                if ($against->type->is(UnitType::Fighter, UnitType::Bomber, UnitType::Helicopter)) {
                    $modifier += 0.2;
                } else {
                    $modifier -= 0.2;
                }
                break;

            case WeaponType::AirBomb:
                if ($against->type->is(UnitType::Towed, UnitType::Tracked, UnitType::Ship, UnitType::HeavyShip)) {
                    $modifier += 0.2;
                } else {
                    $modifier -= 0.2;
                }
                break;

            default:
        }

        return $baseDamage * $modifier;
    }

    public function type(): WeaponType
    {
        return match ($this) {
            self::StoneAxe, self::BronzeSword, self::IronSword, self::SteelSword,
            => WeaponType::Melee,

            self::Arquebus, self::Musket, self::RifleMusket, self::RepeatingRifle,
            => WeaponType::Firearm,

            self::AssaultRifle, self::ScopeRifle, self::LaserRifle,
            => WeaponType::ModernFirearm,

            self::WoodSpear, self::BronzeSpear, self::IronSpear, self::Lance, self::Halberd,
            self::Pike, self::Grenadier,
            => WeaponType::AntiCavalry,

            self::AntiTankRifle, self::RocketGrenade, self::AntiTankMissile,
            => WeaponType::AntiTank,

            self::AntiTankGun, self::HighVelocityGun, self::SmoothBoreGun,
            => WeaponType::AntiTankGun,

            self::AntiAirGun, self::HomingMissile, self::GuidedMissile, self::AiMissile,
            => WeaponType::AntiAir,

            self::WoodThrowingSpear, self::BronzeThrowingSpear, self::IronThrowingSpear, self::Crossbow, self::MachineGun,
            => WeaponType::Skirmish,

            self::Sling, self::Bow, self::CompositeBow, self::Longbow, self::Mortar,
            => WeaponType::Ranged,

            self::Ram, self::Catapult, self::Onager, self::Trebuchet,
            => WeaponType::Siege,

            self::Bombard, self::Cannon,
            => WeaponType::Cannon,

            self::Artillery, self::Howitzer,
            => WeaponType::Artillery,

            self::RocketArtillery, self::RocketSystem,
            => WeaponType::RocketArtillery,

            self::Railgun,
            => WeaponType::Railgun,

            self::AirMachineGun, self::AirHomingMissile, self::AirGuidedMissile, self::AirAiMissile,
            => WeaponType::AirGun,

            self::LightBomb, self::HeavyBomb, self::GuidedBomb,
            => WeaponType::AirBomb,

            self::GasBomb, self::AtomBomb, self::HydrogenBomb,
            => WeaponType::MassDestruction,

            self::Torpedo, self::HomingTorpedo, self::GuidedTorpedo, self::AiTorpedo
            => WeaponType::Torpedo,

            self::WoodenDeck, self::CatapultDeck, self::RadarDeck,
            => WeaponType::FlightDeck,

            self::MissileBay,
            => WeaponType::MissileBay,
        };
    }
}
