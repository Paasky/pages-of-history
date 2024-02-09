<?php

namespace App\Enums;

use App\GameConcept;
use App\UnitArmor\UnitArmorType;
use Illuminate\Support\Collection;

enum UnitArmorCategory: string implements GameConcept
{
    use GameConceptEnum;
    use PohEnum;

    case Air = 'Air';
    case None = 'None';
    case Parachute = 'Parachute';
    case Person = 'Person';
    case Stealth = 'Stealth';
    case Vehicle = 'Vehicle';

    public function icon(): string
    {
        return match ($this) {
            self::Air => 'fa-plane-lock',
            self::None => 'fa-ban',
            self::Parachute => 'fa-parachute-box',
            self::Person => 'fa-user-shield',
            self::Stealth => 'fa-eye-slash',
            self::Vehicle => 'fa-shield',
        };
    }

    /** @return Collection<int, GameConcept> */
    public function items(): Collection
    {
        return UnitArmorType::all()->filter(
            fn(UnitArmorType $type) => $type->category() === $this
        );
    }

    public function typeSlug(): string
    {
        return 'armor';
    }
}
