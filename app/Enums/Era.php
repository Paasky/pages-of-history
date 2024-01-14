<?php

namespace App\Enums;

enum Era: string
{
    use PohEnum;

    case Ancient = 'Ancient'; // 6000 BC - 2000 BC
    case Bronze = 'Bronze'; // 2000 BC -700 BC
    case Iron = 'Iron'; // 700 BC - 500 AD
    case Medieval = 'Medieval'; // 500 AD - 1200 AD
    case Renaissance = 'Renaissance'; // 1200 AD - 1600 AD
    case Enlightenment = 'Enlightenment'; // 1600 AD - 1800 AD
    case Industrial = 'Industrial'; // 1800 AD - 1900 AD
    case Modern = 'Modern'; // 1900 AD - 1945 AD
    case Atomic = 'Atomic'; // 1945 AD - 1985 AD
    case Information = 'Information'; // 1985 AD - 2020 AD
    case Cyber = 'Cyber'; // 2020 AD - 2050 AD

    public function baseDamage(): int
    {
        return match ($this) {
            self::Ancient => 10,
            self::Bronze => 12,
            self::Iron => 16,
            self::Medieval => 19,
            self::Renaissance => 23,
            self::Enlightenment => 31,
            self::Industrial => 38,
            self::Modern => 51,
            self::Atomic => 62,
            self::Information => 83,
            self::Cyber => 100,
        };
    }

    public function orderNumber(): int
    {
        return match ($this) {
            self::Ancient => 1,
            self::Bronze => 2,
            self::Iron => 3,
            self::Medieval => 4,
            self::Renaissance => 5,
            self::Enlightenment => 6,
            self::Industrial => 7,
            self::Modern => 8,
            self::Atomic => 9,
            self::Information => 10,
            self::Cyber => 11,
        };
    }
}
