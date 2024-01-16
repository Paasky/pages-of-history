<?php

namespace App\Enums;

use App\GameConcept;
use App\Improvements\ImprovementType;
use Illuminate\Support\Collection;

enum ImprovementCategory: string implements GameConcept
{
    use GameConceptEnum;

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

    /**
     * @return Collection<int, GameConcept>
     */
    public function items(): Collection
    {
        return ImprovementType::all()->filter(
            fn(ImprovementType $type) => $type->category() === $this
        );
    }

    public function typeSlug(): string
    {
        return 'improvement';
    }
}
