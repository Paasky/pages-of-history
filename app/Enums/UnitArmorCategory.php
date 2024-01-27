<?php

namespace App\Enums;

use App\UnitArmor\UnitArmorType;
use App\GameConcept;
use Illuminate\Support\Collection;

enum UnitArmorCategory: string implements GameConcept
{
    use GameConceptEnum;
    use PohEnum;

    case Person = 'Human';
    case Vehicle = 'Vehicle';
    case Air = 'Air';
    case Camouflage = 'Camouflage';
    case Stealth = 'Stealth';

    public function icon(): string
    {
        return match ($this) {
            self::Person => 'fa-user-shield',
            self::Vehicle => 'fa-shield',
            self::Air => 'fa-plane-lock',
            self::Camouflage => 'fa-tree',
            self::Stealth => 'fa-eye-slash',
        };
    }

    /** @return Collection<int, GameConcept> */
    public function items(): Collection
    {
        return UnitArmorType::all()->filter(
            fn(UnitArmorType $type) => $type->category() === $this
        );
    }

    /** @return Collection<int, UnitPlatformCategory> */
    public function platformCategories(): Collection
    {
        return match ($this) {
            self::Person => collect([
                UnitPlatformCategory::Foot,
                UnitPlatformCategory::Mounted,
            ]),
            self::Vehicle => collect([
                UnitPlatformCategory::Naval,
                UnitPlatformCategory::Vehicle,
            ]),
            self::Air => collect([
                UnitPlatformCategory::Air,
            ]),
            self::Camouflage => collect([
                UnitPlatformCategory::Foot,
            ]),
            self::Stealth => collect([
                UnitPlatformCategory::Air,
                UnitPlatformCategory::Naval,
            ]),
        };
    }

    public function typeSlug(): string
    {
        return 'armor';
    }
}
