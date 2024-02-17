<?php

namespace App\Enums;

use App\GameConcept;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

enum ReligionTenet: string implements GameConcept
{
    use GameConceptEnum;

    case Crusades = 'Crusades';
    case DefendersOfTheFaith = 'DefendersOfTheFaith';
    case WrathOfGod = 'WrathOfGod';
    case Militant = 'Militant';
    case Missionaries = 'Missionaries';
    case Communal = 'Communal';
    case Orthodox = 'Orthodox';
    case Polytheist = 'Polytheist';
    case Naturalist = 'Naturalist';
    case Tithes = 'Tithes';
    case Methodist = 'Methodist';
    case BathingRituals = 'BathingRituals';
    case IdolWorship = 'IdolWorship';
    case Protestant = 'Protestant';
    case Reformist = 'Reformist';

    public function icon(): string
    {
        return YieldType::Faith->icon();
    }

    /** @return Collection<int, GameConcept> */
    public function items(): Collection
    {
        return collect();
    }

    public function typeSlug(): string
    {
        return 'tenet';
    }

    public function yieldModifiers(): Collection
    {
        return match ($this) {
            self::Crusades => collect([new YieldModifier($this, YieldType::Attack, percent: 10)]),
            self::DefendersOfTheFaith => collect([new YieldModifier($this, YieldType::Defense, percent: 10)]),
            self::WrathOfGod => collect([new YieldModifier($this, YieldType::Bombard, percent: 10)]),
            self::Militant => collect([new YieldModifier($this, YieldType::Strength, percent: 10)]),
            self::Missionaries => collect([new YieldModifier($this, YieldType::VisionRange, 1)]),
            self::Communal => collect([new YieldModifier($this, YieldType::Cost, percent: 10)]),
            self::Orthodox => collect([new YieldModifier($this, YieldType::Culture, percent: 10)]),
            self::Polytheist => collect([new YieldModifier($this, YieldType::Faith, percent: 10)]),
            self::Naturalist => collect([new YieldModifier($this, YieldType::Food, percent: 10)]),
            self::Tithes => collect([new YieldModifier($this, YieldType::Gold, percent: 10)]),
            self::Methodist => collect([new YieldModifier($this, YieldType::Happiness, percent: 10)]),
            self::BathingRituals => collect([new YieldModifier($this, YieldType::Health, percent: 10)]),
            self::IdolWorship => collect([new YieldModifier($this, YieldType::Luxury, percent: 10)]),
            self::Protestant => collect([new YieldModifier($this, YieldType::Production, percent: 10)]),
            self::Reformist => collect([new YieldModifier($this, YieldType::Science, percent: 10)]),
        };
    }
}
