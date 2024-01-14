<?php

namespace App\Enums;

enum WeaponType: string
{
    use PohEnum;

    case Melee = 'Melee';
    case Firearm = 'Firearm';
    case ModernFirearm = 'ModernFirearm';
    case AntiCavalry = 'AntiCavalry';
    case AntiTank = 'AntiTank';
    case AntiTankGun = 'AntiTankGun';
    case Skirmish = 'ThrowingSpear';
    case Ranged = 'Ranged';
    case Siege = 'Siege';
    case Cannon = 'Cannon';
    case Artillery = 'Artillery';
    case RocketArtillery = 'RocketArtillery';
    case Torpedo = 'Torpedo';
    case MissileBay = 'MissileBay';
    case FlightDeck = 'FlightDeck';
    case Railgun = 'Railgun';
    case AntiAir = 'AntiAir';
    case AirGun = 'AirGun';
    case AirBomb = 'AirBomb';
    case MassDestruction = 'MassDestruction';

    public function category(): WeaponCategory
    {
        return match ($this) {
            self::Melee, self::Firearm, self::ModernFirearm, self::AntiCavalry, self::AntiTank, self::AntiTankGun
            => WeaponCategory::CloseCombat,

            self::Skirmish, self::Ranged, self::Siege, self::Cannon, self::Artillery, self::RocketArtillery,
            self::Torpedo, self::Railgun,
            => WeaponCategory::Ranged,

            self::AntiAir, self::MissileBay, self::FlightDeck
            => WeaponCategory::Support,

            self::AirGun
            => WeaponCategory::Aerial,

            self::AirBomb
            => WeaponCategory::Bomb,

            self::MassDestruction
            => WeaponCategory::MassDestruction,
        };
    }

    public function upgradesTo(): ?WeaponType
    {
        return match ($this) {
            self::Melee => self::Firearm,
            self::Firearm => self::ModernFirearm,
            self::AntiCavalry => self::AntiTank,
            self::Skirmish => self::Ranged,
            self::Siege => self::Cannon,
            self::Cannon => self::Artillery,
            self::Artillery => self::RocketArtillery,
            self::RocketArtillery => self::Railgun,

            default => null,
        };
    }

    /**
     * @return Weapon[]
     */
    public function weapons(): array
    {
        return array_filter(
            Weapon::cases(),
            fn(Weapon $weapon) => $this->is($weapon->type())
        );
    }
}
