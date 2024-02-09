<?php

namespace App\Enums;

use App\GameConcept;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Support\Collection;

enum UnitPlatformCategory: string implements GameConcept
{
    use GameConceptEnum;

    case Foot = 'Foot';
    case Missile = 'Missile';
    case Mounted = 'Mounted';
    case Vehicle = 'Vehicle';
    case Air = 'Air';
    case Naval = 'Naval';
    case Space = 'Space';

    public function icon(): string
    {
        return match ($this) {
            self::Foot => 'fa-shoe-prints',
            self::Missile => 'fa-rocket',
            self::Mounted => 'fa-horse',
            self::Vehicle => 'fa-car',
            self::Air => 'fa-plane',
            self::Naval => 'fa-ship',
            self::Space => 'fa-satellite',
        };
    }

    /** @return Collection<int, GameConcept> */
    public function items(): Collection
    {
        return UnitPlatformType::all()->filter(
            fn(UnitPlatformType $type) => $type->category() === $this
        );
    }

    public function typeSlug(): string
    {
        return 'platform';
    }
}
