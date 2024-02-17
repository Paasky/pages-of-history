<?php

namespace App\Enums;

use App\GameConcept;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

enum CultureVice: string implements GameConcept
{
    use GameConceptEnum;

    case Corrupt = 'Corrupt';
    case Fundamentalist = 'Fundamentalist';
    case Gluttonous = 'Gluttonous';
    case Ignorant = 'Ignorant';
    case Jealous = 'Jealous';
    case Lazy = 'Lazy';
    case Traditionalist = 'Traditionalist';
    case Unsanitary = 'Unsanitary';

    public function icon(): string
    {
        return match ($this) {
            self::Corrupt => 'fa-hand-holding-dollar',
            self::Fundamentalist => 'fa-place-of-worship',
            self::Gluttonous => 'fa-wheat-awn-circle-exclamation',
            self::Ignorant => 'fa-wand-sparkles',
            self::Jealous => 'fa-face-frown',
            self::Lazy => 'fa-bed',
            self::Traditionalist => 'fa-ban',
            self::Unsanitary => 'fa-trash-can',
        };
    }

    /** @return Collection<int, GameConcept> */
    public function items(): Collection
    {
        return collect();
    }

    public function typeSlug(): string
    {
        return 'vice';
    }

    public function yieldModifiers(): Collection
    {
        return match ($this) {
            self::Corrupt => collect([new YieldModifier($this, YieldType::Gold, percent: -20)]),
            self::Fundamentalist => collect([new YieldModifier($this, YieldType::Faith, percent: -20)]),
            self::Gluttonous => collect([new YieldModifier($this, YieldType::Food, percent: -20)]),
            self::Ignorant => collect([new YieldModifier($this, YieldType::Science, percent: -20)]),
            self::Jealous => collect([new YieldModifier($this, YieldType::Happiness, percent: -20)]),
            self::Lazy => collect([new YieldModifier($this, YieldType::Production, percent: -20)]),
            self::Traditionalist => collect([new YieldModifier($this, YieldType::Culture, percent: -20)]),
            self::Unsanitary => collect([new YieldModifier($this, YieldType::Health, percent: -20)]),
        };
    }
}
