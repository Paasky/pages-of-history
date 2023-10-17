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
        switch ($surface) {
            case HexSurface::Coast:
                return [null, HexFeature::Shoals, HexFeature::Reef];
            case HexSurface::Sea:
                return [null, HexFeature::Reef];
            case HexSurface::Ocean:
                return [null];
            case HexSurface::Desert:
                return [null, HexFeature::Dunes, HexFeature::Shrubs];
            case HexSurface::Snow:
                return [null, HexFeature::Shrubs, HexFeature::Snowdrifts];
            case HexSurface::Rock:
                return [null, HexFeature::Shrubs];
            case HexSurface::Tundra:
                return [null, HexFeature::Shrubs, HexFeature::LightForest, HexFeature::PineForest];
            case HexSurface::Plains:
                return [null, HexFeature::Shrubs, HexFeature::LightForest];
            case HexSurface::Grass:
                return [null, HexFeature::Shrubs, HexFeature::LightForest, HexFeature::LushForest, HexFeature::Jungle];

        }
    }
}
