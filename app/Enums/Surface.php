<?php

namespace App\Enums;

enum Surface: string
{
    use PohEnum;

    case Grass = 'Grass';
    case Plains = 'Plains';
    case Desert = 'Desert';
    case Tundra = 'Tundra';
    case Snow = 'Snow';
    case Rock = 'Rock';
    case Coast = 'Coast';
    case River = 'River';
    case Sea = 'Sea';
    case Ocean = 'Ocean';

    public function domain(): Domain
    {
        return match ($this) {
            self::Coast, self::River, self::Sea, self::Ocean => Domain::Water,
            default => Domain::Land,
        };
    }

    public function cssBackground(): string
    {
        return match ($this) {
            self::Grass => "url('/tiles/grass.png')",
            self::Plains => "url('/tiles/plains.png')",
            self::Desert => "url('/tiles/desert.png')",
            self::Tundra => "url('/tiles/tundra.png')",
            self::Snow => "url('/tiles/snow.png')",
            self::Rock => "url('/tiles/rock.png')",
            self::Coast => "url('/tiles/coast.png')",
            self::River => "url('/tiles/river.png')",
            self::Sea => "url('/tiles/sea.png')",
            self::Ocean => "url('/tiles/ocean.png')",
        };
    }

    public function moveCost(): int
    {
        return match ($this) {
            self::Rock, self::Snow => 2,
            default => 1,
        };
    }
}
