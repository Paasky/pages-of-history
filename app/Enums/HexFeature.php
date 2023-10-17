<?php

namespace App\Enums;

enum HexFeature
{
    case Shrubs;
    case LightForest;
    case LushForest;
    case PineForest;
    case Jungle;
    case Dunes;
    case Snowdrifts;
    case Shoals;
    case Reef;

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
