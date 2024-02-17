<?php

namespace App\Enums;

use App\GameConcept;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

enum Feature: string implements GameConcept
{
    use GameConceptEnum;

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
            self::Shrubs => "url('/tiles/shrubs.jpg')",
            self::LightForest => "url('/tiles/light-forest.jpg')",
            self::LushForest => "url('/tiles/lush-forest.jpg')",
            self::PineForest => "url('/tiles/pine-forest.jpg')",
            self::Jungle => "url('/tiles/jungle.jpg')",
            self::Dunes => "url('/tiles/dunes.jpg')",
            self::Snowdrifts => "url('/tiles/snowdrifts.jpg')",
            self::Shoals => "url('/tiles/shoals.jpg')",
            self::Reef => "url('/tiles/reefs.jpg')",
            self::FloodPlain => "url('/tiles/flood-plains.jpg')",
            self::Oasis => "url('/tiles/oasis.jpg')",
        };
    }

    public function icon(): string
    {
        return 'fa-layer-group';
    }

    /** @return Collection<int, GameConcept> */
    public function items(): Collection
    {
        return collect();
    }

    public function typeSlug(): string
    {
        return 'feature';
    }

    public function yieldModifiers(): Collection
    {
        return match ($this) {
            self::LightForest, self::Shrubs => collect([
                new YieldModifier($this, YieldType::Production, 1),
                new YieldModifier($this, YieldType::Defense, percent: 10),
            ]),
            self::LushForest, self::PineForest => collect([
                new YieldModifier($this, YieldType::Moves, -1),
                new YieldModifier($this, YieldType::Defense, percent: 20),
                new YieldModifier($this, YieldType::Production, 1),
            ]),
            self::Jungle => collect([
                new YieldModifier($this, YieldType::Moves, -1),
                new YieldModifier($this, YieldType::Health, percent: -20),
                new YieldModifier($this, YieldType::Defense, percent: 30),
                new YieldModifier($this, YieldType::Production, 1),
                new YieldModifier($this, YieldType::Science, 1),
            ]),
            self::Dunes, self::Snowdrifts => collect([
                new YieldModifier($this, YieldType::Moves, -1),
                new YieldModifier($this, YieldType::Defense, percent: 10),
            ]),
            self::Shoals => collect([
                new YieldModifier($this, YieldType::Moves, -1),
                new YieldModifier($this, YieldType::Health, percent: -20),
                new YieldModifier($this, YieldType::Food, 1),
                new YieldModifier($this, YieldType::Production, 1),
            ]),
            self::Reef => collect([
                new YieldModifier($this, YieldType::Moves, -1),
                new YieldModifier($this, YieldType::Health, percent: -20),
                new YieldModifier($this, YieldType::Food, 1),
                new YieldModifier($this, YieldType::Gold, 1),
            ]),
            self::FloodPlain => collect([
                new YieldModifier($this, YieldType::Food, 3),
            ]),
            self::Oasis => collect([
                new YieldModifier($this, YieldType::Food, 1),
                new YieldModifier($this, YieldType::Gold, 1),
                new YieldModifier($this, YieldType::Production, 1),
            ]),
        };
    }
}
