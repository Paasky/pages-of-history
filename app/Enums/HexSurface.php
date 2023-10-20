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

    public function cssBackground(): string
    {
        return match ($this) {
            HexSurface::Grass => "url('/tiles/grass.jpg')", // '#0d530e',
            HexSurface::Plains => "url('/tiles/plains.jpg')", // '#5f723e',
            HexSurface::Desert => "url('/tiles/desert.jpg')", // '#ada570',
            HexSurface::Tundra => "url('/tiles/tundra.jpg')", // '#798570',
            HexSurface::Snow => "url('/tiles/snow.jpg')", // '#9faba8',
            HexSurface::Rock => "url('/tiles/rock.jpg')", // '#3f423d',
            HexSurface::Coast => "url('/tiles/coast.jpg')", // '#629099',
            HexSurface::Sea => "url('/tiles/sea.jpg')", // '#344457',
            HexSurface::Ocean => "url('/tiles/ocean.jpg')", // '#142e4d',
            default => '#999',
        };
    }
}
