<?php

namespace App\Enums;

enum UnitType: string
{
    use PohEnum;

    case Builder = 'Builder';
    case Settler = 'Settler';
    case Scout = 'Scout';
    case Infantry = 'Infantry';
    case HeavyInfantry = 'HeavyInfantry';
    case Ranged = 'Ranged';
    case Mounted = 'Mounted';
    case Siege = 'Siege';
    case Ship = 'Ship';
    case HeavyShip = 'HeavyShip';
    case SupportShip = 'SupportShip';
    case Bomber = 'Bomber';
    case Fighter = 'Fighter';
    case Helicopter = 'Helicopter';
    case Missile = 'Missile';

    public function domain(): UnitDomain
    {
        return match ($this) {
            self::Builder, self::Settler,
            self::HeavyInfantry, self::Infantry, self::Mounted,
            self::Ranged, self::Scout, self::Siege =>
            UnitDomain::Land,
            self::HeavyShip, self::Ship, self::SupportShip =>
            UnitDomain::Water,
            self::Bomber, self::Fighter, self::Helicopter, self::Missile =>
            UnitDomain::Air,
            default => throw new \Exception("No domain for unit type $this->value"),
        };
    }

    public function category(): UnitCategory
    {
        return match ($this) {
            self::Builder, self::Settler =>
            UnitCategory::Civilian,
            self::HeavyInfantry, self::Infantry, self::Mounted,
            self::HeavyShip, self::Ship,
            self::Bomber, self::Fighter =>
            UnitCategory::Combat,
            self::Ranged, self::Scout, self::Siege,
            self::SupportShip,
            self::Helicopter, self::Missile =>
            UnitCategory::Support,
            default => throw new \Exception("No category for unit type $this->value"),
        };
    }
}
