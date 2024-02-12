<?php

namespace App\Enums;

use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

enum Feature: string
{
    use PohEnum;

    case FloodPlain = 'FloodPlain';
    case Shrubs = 'Shrubs';
    case LightForest = 'LightForest';
    case LushForest = 'LushForest';
    case PineForest = 'PineForest';
    case Jungle = 'Jungle';
    case Dunes = 'Dunes';
    case Oasis = 'Oasis';
    case Snowdrifts = 'Snowdrifts';
    case Shoals = 'Shoals';
    case Reef = 'Reef';

    /**
     * @param Surface $surface
     * @return Feature[]
     */
    public static function casesForSurface(Surface $surface): array
    {
        return match ($surface) {
            Surface::Coast => [null, self::Shoals, self::Reef],
            Surface::Sea => [null, self::Reef],
            Surface::Ocean => [null],
            Surface::Desert => [null, self::Dunes, self::FloodPlain, self::Oasis, self::Shrubs],
            Surface::Snow => [null, self::Shrubs, self::Snowdrifts],
            Surface::Rock => [null, self::Shrubs],
            Surface::Tundra => [null, self::Shrubs, self::LightForest, self::PineForest],
            Surface::Plains => [null, self::Shrubs, self::LightForest],
            Surface::Grass => [null, self::Shrubs, self::LightForest, self::LushForest, self::Jungle],
            Surface::River => [null, self::Shoals],
        };
    }

    public function cssBackground(): string
    {
        return match ($this) {
            self::Shrubs => "url('/tiles/shrubs.png')",
            self::LightForest => "url('/tiles/light-forest.png')",
            self::LushForest => "url('/tiles/lush-forest.jpg')",
            self::PineForest => "url('/tiles/pine-forest.jpg')",
            self::Jungle => "url('/tiles/jungle.jpg')",
            self::Dunes => "url('/tiles/dunes.jpg')",
            self::Snowdrifts => "url('/tiles/snowdrifts.jpg')",
            self::Shoals => "url('/tiles/shoals.png')",
            self::Reef => "url('/tiles/reef.png')",
            self::FloodPlain => "url('/tiles/dunes.jpg')",
            self::Oasis => "url('/tiles/shoals.png')",
        };
    }

    public function moveCost(): int
    {
        return match ($this) {
            self::Dunes, self::Jungle, self::LushForest, self::PineForest,
            self::Reef, self::Shoals, self::Snowdrifts => 1,
            default => 0,
        };
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return match ($this) {
            self::Shrubs => "url('/tiles/shrubs.png')",
            self::LightForest => "url('/tiles/light-forest.png')",
            self::LushForest => "url('/tiles/lush-forest.jpg')",
            self::PineForest => "url('/tiles/pine-forest.jpg')",
            self::Jungle => "url('/tiles/jungle.jpg')",
            self::Dunes => "url('/tiles/dunes.jpg')",
            self::Snowdrifts => "url('/tiles/snowdrifts.jpg')",
            self::Shoals => "url('/tiles/shoals.png')",
            self::Reef => "url('/tiles/reef.png')",
        };

    }
}
