<?php

namespace App\Enums;

use App\GameConcept;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

enum CultureVirtue: string implements GameConcept
{
    use GameConceptEnum;

    case Artistic = 'Artistic';
    case Cooperative = 'Cooperative';
    case HardWorking = 'HardWorking';
    case Hygienic = 'Hygienic';
    case Inquisitive = 'Inquisitive';
    case Joyful = 'Joyful';
    case Spiritual = 'Spiritual';
    case Trading = 'Trading';

    public function icon(): string
    {
        return match ($this) {
            self::Artistic => YieldType::Culture->icon(),
            self::Cooperative => YieldType::Food->icon(),
            self::HardWorking => YieldType::Production->icon(),
            self::Hygienic => YieldType::Health->icon(),
            self::Inquisitive => YieldType::Science->icon(),
            self::Joyful => YieldType::Happiness->icon(),
            self::Spiritual => YieldType::Faith->icon(),
            self::Trading => YieldType::Gold->icon(),
        };
    }

    /** @return Collection<int, GameConcept> */
    public function items(): Collection
    {
        return collect();
    }

    public function typeSlug(): string
    {
        return 'virtue';
    }

    public function yieldModifiers(): Collection
    {
        return match ($this) {
            self::Artistic => collect([new YieldModifier($this, YieldType::Culture, percent: 10)]),
            self::Cooperative => collect([new YieldModifier($this, YieldType::Food, percent: 10)]),
            self::HardWorking => collect([new YieldModifier($this, YieldType::Production, percent: 10)]),
            self::Hygienic => collect([new YieldModifier($this, YieldType::Health, percent: 10)]),
            self::Inquisitive => collect([new YieldModifier($this, YieldType::Science, percent: 10)]),
            self::Joyful => collect([new YieldModifier($this, YieldType::Happiness, percent: 10)]),
            self::Spiritual => collect([new YieldModifier($this, YieldType::Faith, percent: 10)]),
            self::Trading => collect([new YieldModifier($this, YieldType::Gold, percent: 10)]),
        };
    }
}
