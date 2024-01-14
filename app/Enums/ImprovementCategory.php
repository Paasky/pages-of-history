<?php

namespace App\Enums;

enum ImprovementCategory: string
{
    case Camps = 'Camps';
    case Cities = 'Cities';
    case Farms = 'Farms';
    case Fisheries = 'Fisheries';
    case Forts = 'Forts';
    case Mines = 'Mines';
    case Pastures = 'Pastures';
    case Plantations = 'Plantations';
    case Quarries = 'Quarries';
    case Towns = 'Towns';

    public function icon(): string
    {
        return match ($this) {
            self::Camps => 'fa-campground',
            self::Cities => 'fa-city',
            self::Farms => 'fa-plate-wheat',
            self::Fisheries => 'fa-fish-fins',
            self::Forts => 'fa-chess-rook',
            self::Mines => 'fa-person-digging',
            self::Pastures => 'fa-hat-cowboy',
            self::Plantations => 'fa-seedling',
            self::Quarries => 'fa-hill-rockslide',
            self::Towns => 'fa-house',
        };
    }

    public function name(): string
    {
        return $this->name;
    }

    public function shortName(): string
    {
        return $this->name;
    }


    public function typeSlug(): string
    {
        return 'improvement';
    }
}
