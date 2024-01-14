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
            self::Grass => "url('/tiles/grass.jpg')", // '#0d530e',
            self::Plains => "url('/tiles/plains.jpg')", // '#5f723e',
            self::Desert => "url('/tiles/desert.jpg')", // '#ada570',
            self::Tundra => "url('/tiles/tundra.jpg')", // '#798570',
            self::Snow => "url('/tiles/snow.jpg')", // '#9faba8',
            self::Rock => "url('/tiles/rock.jpg')", // '#3f423d',
            self::Coast => "url('/tiles/coast.jpg')", // '#629099',
            self::River => "url('/tiles/river.jpg')", // '#629099',
            self::Sea => "url('/tiles/sea.jpg')", // '#344457',
            self::Ocean => "url('/tiles/ocean.jpg')", // '#142e4d',
            default => '#999',
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
