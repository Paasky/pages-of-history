<?php

namespace App\Enums;

use App\GameConcept;
use Illuminate\Support\Collection;

enum UnitType: string implements GameConcept
{
    use GameConceptEnum;

    case Combat = 'Combat';
    case Civilian = 'Civilian';
    case Support = 'Support';

    public function icon(): string
    {
        return match ($this) {
            self::Combat => YieldType::Strength->icon(),
            self::Civilian => YieldType::Production->icon(),
            self::Support => YieldType::Range->icon(),
        };
    }

    /** @return Collection<int, GameConcept> */
    public function items(): Collection
    {
        return collect();
    }

    public function typeSlug(): string
    {
        return 'unit-type';
    }
}
