<?php

namespace App\Enums;

use App\Managers\MapManager;

enum UnitType: string
{
    use PohEnum;

    case Builder = 'Builder';
    case Settler = 'Settler';
    case Skirmisher = 'Skirmisher';
    case Infantry = 'Infantry';
    case HeavyInfantry = 'HeavyInfantry';
    case Ranged = 'Ranged';
    case Mounted = 'Mounted';
    case Towed = 'Towed';
    case Tracked = 'Tracked';
    case Siege = 'Siege';
    case HorseDrawn = 'HorseDrawn';
    case Ship = 'Ship';
    case HeavyShip = 'HeavyShip';
    case Submarine = 'Submarine';
    case Fighter = 'Fighter';
    case Bomber = 'Bomber';
    case Helicopter = 'Helicopter';
    case Missile = 'Missile';

    /**
     * @return Armor[]|null[]
     */
    public function armors(Weapon $withWeapon = null): array
    {
        // No Armor allowed for Ranged
        if ($withWeapon?->type()->is(WeaponType::Ranged)) {
            return [null];
        }

        $armors = [];
        foreach ($this->armorTypes() as $armorType) {
            if (!$armorType) {
                $armors[] = null;
                continue;
            }

            foreach ($armorType->armors() as $armor) {
                // Max 2 era difference between armor and weapon
                if ($withWeapon) {
                    if ($withWeapon->category()->is(WeaponCategory::Aerial, WeaponCategory::Bomb, WeaponCategory::MassDestruction)) {
                        if ($armor->era()->orderNumber() !== $withWeapon->era()->orderNumber()) {
                            continue;
                        }
                    }
                    if (abs($armor->era()->orderNumber() - $withWeapon->era()->orderNumber()) > 1) {
                        continue;
                    }
                }

                $armors[] = $armor;
            }
        }
        return $armors;
    }

    /**
     * @return ArmorType[]|null[]
     */
    public function armorTypes(): array
    {
        return match ($this) {
            self::Builder, self::Settler, self::Infantry, self::Ranged,
            self::Siege, self::HorseDrawn, self::Missile,
            => [null],

            self::Mounted,
            => [null, ArmorType::Human],

            self::HeavyInfantry,
            => [ArmorType::Human],

            self::Tracked, self::HeavyShip,
            => [ArmorType::Vehicle],

            self::Fighter, self::Bomber, self::Helicopter,
            => [null, ArmorType::Air, ArmorType::Stealth],

            self::Skirmisher,
            => [null, ArmorType::Camouflage],

            self::Towed, self::Ship, self::Submarine,
            => [null, ArmorType::Camouflage, ArmorType::Stealth],
        };
    }

    public function category(): UnitCategory
    {
        return match ($this) {
            self::Builder, self::Settler,
            => UnitCategory::Civilian,

            self::HeavyInfantry, self::Infantry, self::Mounted, self::Towed, self::Tracked,
            self::HeavyShip, self::Ship, self::Submarine,
            self::Bomber, self::Fighter,
            => UnitCategory::Combat,

            self::Ranged, self::Skirmisher, self::Siege, self::HorseDrawn,
            self::Helicopter, self::Missile,
            => UnitCategory::Support,
        };
    }

    public function costMultiplier(): float
    {
        return match ($this) {
            self::Builder, self::Infantry, self::Ship, self::Submarine, self::Skirmisher, self::Missile,
            => 1.0,

            self::HeavyInfantry, self::Ranged, self::Siege, self::Mounted, self::Towed, self::Fighter, self::Helicopter,
            => 1.5,

            self::Settler, self::HorseDrawn, self::Tracked, self::HeavyShip, self::Bomber,
            => 2.0,
        };
    }

    public function domain(): Domain
    {
        return match ($this) {
            self::Builder, self::Settler, self::HeavyInfantry, self::Infantry, self::Mounted,
            self::Ranged, self::Skirmisher, self::Siege, self::HorseDrawn, self::Towed, self::Tracked,
            => Domain::Land,

            self::HeavyShip, self::Ship, self::Submarine,
            => Domain::Water,

            self::Bomber, self::Fighter, self::Helicopter, self::Missile,
            => Domain::Air,
        };
    }

    public function maxElevationPerMove(): int
    {
        return match ($this) {
            self::Builder, self::Settler, self::Infantry, self::Ranged, self::Skirmisher, self::Tracked,
            => 3,

            self::HeavyInfantry, self::Mounted, self::Siege, self::HorseDrawn, self::Towed,
            => 2,

            self::HeavyShip, self::Ship, self::Submarine,
            => 1,

            self::Bomber, self::Fighter, self::Helicopter, self::Missile,
            => MapManager::MAX_ELEVATION,

        };
    }

    /**
     * @return Weapon[]|null[]
     */
    public function weapons(): array
    {
        $weapons = [];
        foreach ($this->weaponTypes() as $weaponType) {
            if (!$weaponType) {
                $weapons[] = null;
                continue;
            }

            foreach ($weaponType->weapons() as $weapon) {
                $weapons[] = $weapon;
            }
        }
        return $weapons;
    }

    /**
     * @return WeaponType[]|null[]
     */
    public function weaponTypes(): array
    {
        return match ($this) {
            self::Builder, self::Settler,
            => [null],

            self::Skirmisher,
            => [WeaponType::Skirmish],

            self::Infantry, self::HeavyInfantry,
            => [WeaponType::Melee, WeaponType::Firearm, WeaponType::ModernFirearm, WeaponType::AntiCavalry, WeaponType::AntiTank],

            self::Ranged,
            => [WeaponType::Ranged],

            self::Mounted,
            => [WeaponType::Melee, WeaponType::Firearm, WeaponType::AntiCavalry, WeaponType::AntiTank, WeaponType::Ranged, WeaponType::Skirmish],

            self::Towed, self::Tracked
            => [WeaponType::AntiTankGun, WeaponType::Artillery, WeaponType::RocketArtillery],

            self::Siege
            => [WeaponType::Siege, WeaponType::Cannon],

            self::HorseDrawn
            => [WeaponType::Cannon, WeaponType::Artillery],

            self::Ship,
            => [
                WeaponType::Siege, WeaponType::Cannon, WeaponType::Artillery, WeaponType::RocketArtillery,
                WeaponType::MissileBay, WeaponType::FlightDeck,
            ],

            self::HeavyShip,
            => [
                WeaponType::Siege, WeaponType::Cannon, WeaponType::Artillery, WeaponType::Railgun,
            ],

            self::Submarine,
            => [WeaponType::Torpedo, WeaponType::MissileBay],

            self::Fighter,
            => [WeaponType::AirGun],

            self::Bomber, self::Missile,
            => [WeaponType::AirBomb, WeaponType::MassDestruction],

            self::Helicopter,
            => [WeaponType::AirGun, WeaponType::AirBomb],
        };
    }
}
