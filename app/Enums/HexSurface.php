<?php

namespace App\Enums;

enum HexSurface:string
{
    use PohEnum;

    case Grass = 'Grass';
    case Plains = 'Plains';
    case Desert = 'Desert';
    case Tundra = 'Tundra';
    case Snow = 'Snow';
    case Rock = 'Rock';
    case Coast = 'Coast';
    case Sea = 'Sea';
    case Ocean = 'Ocean';

    public function isWater(): bool
    {
        return in_array($this, [HexSurface::Coast, HexSurface::Sea, HexSurface::Ocean]);
    }

    public function cssColor(): string
    {
        return match ($this) {
            HexSurface::Grass => '#0d530e',
            HexSurface::Plains => '#767943',
            HexSurface::Desert => '#ada570',
            HexSurface::Tundra => '#798570',
            HexSurface::Snow => '#9faba8',
            HexSurface::Rock => '#3f423d',
            HexSurface::Coast => '#629099',
            HexSurface::Sea => '#344457',
            HexSurface::Ocean => '#142e4d',
            default => '#999',
        };
    }
}
