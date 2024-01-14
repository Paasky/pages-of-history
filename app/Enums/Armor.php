<?php

namespace App\Enums;

enum Armor: string
{
    use PohEnum;

    public const CostMultiplier = 10;

    case WoodenShield = 'WoodenShield';
    case BronzePlate = 'BronzePlate';
    case IronPlate = 'IronPlate';
    case Chainmail = 'Chainmail';
    case SteelPlate = 'SteelPlate';
    case Camouflage = 'Camouflage';
    case Multideck = 'Multideck';
    case Ironclad = 'Ironclad';
    case Armor = 'Armor';
    case HeavyArmor = 'HeavyArmor';
    case BodyArmor = 'BodyArmor';
    case CompositeArmor = 'CompositeArmor';
    case Stealth = 'Stealth';
    case AdvancedStealth = 'AdvancedStealth';
    case ActiveDefense = 'ActiveDefense';
    case SealingTanks = 'SealingTanks';
    case ChaffFlare = 'ChaffFlare';

    public function cost(): int
    {
        return $this->strength() * Armor::CostMultiplier;
    }

    public function era(): Era
    {
        return match ($this) {
            self::WoodenShield,
            => Era::Ancient,

            self::BronzePlate,
            => Era::Bronze,

            self::IronPlate,
            => Era::Iron,

            self::Chainmail,
            => Era::Medieval,

            self::SteelPlate, self::Multideck,
            => Era::Renaissance,

            self::Ironclad,
            => Era::Industrial,

            self::Camouflage, self::Armor, self::SealingTanks,
            => Era::Modern,

            self::HeavyArmor, self::ChaffFlare,
            => Era::Atomic,

            self::BodyArmor, self::CompositeArmor, self::Stealth,
            => Era::Information,

            self::ActiveDefense, self::AdvancedStealth,
            => Era::Cyber,
        };
    }

    public function strength(): float
    {
        return match ($this->era()) {
            Era::Ancient => 3,
            Era::Bronze => 4,
            Era::Iron => 5,
            Era::Medieval => 6,
            Era::Renaissance => 7,
            Era::Enlightenment => 8,
            Era::Industrial => 10,
            Era::Modern => 12,
            Era::Atomic => 14,
            Era::Information => 17,
            Era::Cyber => 20,
        };
    }

    public function type(): ArmorType
    {
        return match ($this) {
            self::WoodenShield, self::BronzePlate, self::IronPlate, self::Chainmail, self::SteelPlate,
            self::BodyArmor,
            => ArmorType::Human,

            self::Multideck, self::Ironclad, self::Armor, self::HeavyArmor, self::CompositeArmor, self::ActiveDefense,
            => ArmorType::Vehicle,

            self::SealingTanks, self::ChaffFlare,
            => ArmorType::Air,

            self::Camouflage,
            => ArmorType::Camouflage,

            self::Stealth, self::AdvancedStealth,
            => ArmorType::Stealth,
        };
    }
}
