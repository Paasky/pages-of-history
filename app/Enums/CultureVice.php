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
    case Traditional = 'Traditional';
    case Unsanitary = 'Unsanitary';

    public function icon(): string
    {
        return match ($this) {
            self::Corrupt => YieldType::Gold->icon(),
            self::Fundamentalist => YieldType::Faith->icon(),
            self::Gluttonous => YieldType::Food->icon(),
            self::Ignorant => YieldType::Science->icon(),
            self::Jealous => YieldType::Happiness->icon(),
            self::Lazy => YieldType::Production->icon(),
            self::Traditional => YieldType::Culture->icon(),
            self::Unsanitary => YieldType::Health->icon(),
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
            self::Corrupt => collect([new YieldModifier(YieldType::Gold, percent: -20)]),
            self::Fundamentalist => collect([new YieldModifier(YieldType::Faith, percent: -20)]),
            self::Gluttonous => collect([new YieldModifier(YieldType::Food, percent: -20)]),
            self::Ignorant => collect([new YieldModifier(YieldType::Science, percent: -20)]),
            self::Jealous => collect([new YieldModifier(YieldType::Happiness, percent: -20)]),
            self::Lazy => collect([new YieldModifier(YieldType::Production, percent: -20)]),
            self::Traditional => collect([new YieldModifier(YieldType::Culture, percent: -20)]),
            self::Unsanitary => collect([new YieldModifier(YieldType::Health, percent: -20)]),
        };
    }
}
