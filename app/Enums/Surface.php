<?php

namespace App\Enums;

use App\GameConcept;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

enum Surface: string implements GameConcept
{
    use GameConceptEnum;

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
        return 'surface';
    }

    public function yieldModifiers(): Collection
    {
        return match ($this) {
            self::Grass => collect([
                new YieldModifier(YieldType::Moves, -1),
                new YieldModifier(YieldType::Food, 2),
            ]),
            self::Plains => collect([
                new YieldModifier(YieldType::Moves, -1),
                new YieldModifier(YieldType::Food, 1),
                new YieldModifier(YieldType::Production, 1),
            ]),
            self::Desert, self::Snow => collect([
                new YieldModifier(YieldType::Moves, -2),
                new YieldModifier(YieldType::Health, percent: -20),
            ]),
            self::Tundra => collect([
                new YieldModifier(YieldType::Moves, -1),
                new YieldModifier(YieldType::Food, 1),
            ]),
            self::Rock => collect([
                new YieldModifier(YieldType::Moves, -2),
                new YieldModifier(YieldType::Production, 2),
            ]),
            self::Coast, self::River => collect([
                new YieldModifier(YieldType::Moves, -1),
                new YieldModifier(YieldType::Food, 1),
                new YieldModifier(YieldType::Gold, 1),
            ]),
            self::Sea => collect([
                new YieldModifier(YieldType::Moves, -1),
            ]),
            self::Ocean => collect([
                new YieldModifier(YieldType::Moves, -0.5),
            ]),
        };
    }
}
