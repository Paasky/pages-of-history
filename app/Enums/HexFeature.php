<?php

namespace App\Enums;

enum HexFeature:string
{
    use PohEnum;

    case Shrubs = 'Shrubs';
    case LightForest = 'LightForest';
    case LushForest = 'LushForest';
    case PineForest = 'PineForest';
    case Jungle = 'Jungle';
    case Dunes = 'Dunes';
    case Snowdrifts = 'Snowdrifts';
    case Shoals = 'Shoals';
    case Reef = 'Reef';

    /**
     * @param HexSurface $surface
     * @return HexFeature[]
     */
    public static function casesForSurface(HexSurface $surface): array
    {
        return match ($surface) {
            HexSurface::Coast => [null, HexFeature::Shoals, HexFeature::Reef],
            HexSurface::Sea => [null, HexFeature::Reef],
            HexSurface::Ocean => [null],
            HexSurface::Desert => [null, HexFeature::Dunes, HexFeature::Shrubs],
            HexSurface::Snow => [null, HexFeature::Shrubs, HexFeature::Snowdrifts],
            HexSurface::Rock => [null, HexFeature::Shrubs],
            HexSurface::Tundra => [null, HexFeature::Shrubs, HexFeature::LightForest, HexFeature::PineForest],
            HexSurface::Plains => [null, HexFeature::Shrubs, HexFeature::LightForest],
            HexSurface::Grass => [null, HexFeature::Shrubs, HexFeature::LightForest, HexFeature::LushForest, HexFeature::Jungle],
        };
    }

    public function cssBackground(): string
    {
        return match ($this) {
            HexFeature::Shrubs => "url('/tiles/shrubs.png')",
            HexFeature::LightForest => "url('/tiles/light-forest.png')",
            HexFeature::LushForest => "url('/tiles/lush-forest.jpg')",
            HexFeature::PineForest => "url('/tiles/pine-forest.jpg')",
            HexFeature::Jungle => "url('/tiles/jungle.jpg')",
            HexFeature::Dunes => "url('/tiles/dunes.jpg')",
            HexFeature::Snowdrifts => "url('/tiles/snowdrifts.jpg')",
            HexFeature::Shoals => "url('/tiles/shoals.png')",
            HexFeature::Reef => "url('/tiles/reef.png')",
            default => '#999',
        };
    }

    public function moveCost(): int
    {
        return match ($this) {
            HexFeature::Dunes, HexFeature::Jungle, HexFeature::LushForest, HexFeature::PineForest,
            HexFeature::Reef, HexFeature::Shoals, HexFeature::Snowdrifts => 1,
            default => 0,
        };
    }
}
