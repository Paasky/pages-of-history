<?php

namespace App\Enums;

enum HexSurface
{
    case Grass;
    case Plains;
    case Desert;
    case Tundra;
    case Snow;
    case Rock;
    case Coast;
    case Sea;
    case Ocean;

    public function isWater(): bool
    {
        return in_array($this, [HexSurface::Coast, HexSurface::Sea, HexSurface::Ocean]);
    }
}
