<?php

namespace App\Enums;

use App\GameConcept;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

enum CultureTrait: string implements GameConcept
{
    use GameConceptEnum;

    case Agrarian = 'Agrarian';
    case Arctic = 'Arctic';
    case Bedouin = 'Bedouin';
    case Hunter = 'Hunter';
    case Nomadic = 'Nomadic';
    case Seafaring = 'Seafaring';
    case Tropical = 'Tropical';

    public function icon(): string
    {
        return match ($this) {
            self::Agrarian => 'fa fa-wheat-awn',
            self::Arctic => 'fa fa-snowflake',
            self::Bedouin => 'fa fa-tent',
            self::Hunter => 'fa fa-tree',
            self::Nomadic => 'fa fa-horse',
            self::Seafaring => 'fa fa-sailboat',
            self::Tropical => 'fa fa-umbrella-beach',
        };
    }

    /** @return Collection<int, GameConcept> */
    public function items(): Collection
    {
        return collect();
    }

    public function typeSlug(): string
    {
        return 'trait';
    }

    public function yieldModifiers(): Collection
    {
        return match ($this) {
            self::Agrarian => collect([
                new YieldModifiersFor(
                    new YieldModifier(YieldType::Food, 1),
                    ImprovementCategory::Farms
                )
            ]),
            self::Arctic => collect([
                new YieldModifiersFor(
                    new YieldModifier(YieldType::Production, 1),
                    Surface::Tundra
                ),
                new YieldModifiersFor(
                    [
                        new YieldModifier(YieldType::Moves, 1),
                        new YieldModifier(YieldType::Health, percent: 20),
                    ],
                    Surface::Snow
                ),
            ]),
            self::Bedouin => collect([
                new YieldModifiersFor(
                    new YieldModifier(YieldType::Food, 1),
                    Feature::Shrubs
                ),
                new YieldModifiersFor(
                    [
                        new YieldModifier(YieldType::Moves, 1),
                        new YieldModifier(YieldType::Health, percent: 20),
                    ],
                    Surface::Desert
                ),
            ]),
            self::Hunter => collect([
                new YieldModifiersFor(
                    new YieldModifier(YieldType::Moves, 1),
                    [Feature::LushForest, Feature::PineForest]
                ),
                new YieldModifiersFor(
                    new YieldModifier(YieldType::Food, 1),
                    ImprovementCategory::Camps
                ),
            ]),
            self::Nomadic => collect([
                new YieldModifiersFor(
                    new YieldModifier(YieldType::Food, 1),
                    Feature::Shrubs
                ),
                new YieldModifiersFor(
                    new YieldModifier(YieldType::Gold, 1),
                    ImprovementCategory::Camps
                ),
            ]),
            self::Seafaring => collect([
                new YieldModifiersFor(
                    new YieldModifier(YieldType::Production, 1),
                    ImprovementCategory::Fisheries
                ),
                new YieldModifiersFor(
                    new YieldModifier(YieldType::Food, 1),
                    Surface::Sea
                ),
            ]),
            self::Tropical => collect([
                new YieldModifiersFor(
                    [
                        new YieldModifier(YieldType::Food, 1),
                        new YieldModifier(YieldType::Moves, 1),
                        new YieldModifier(YieldType::Health, percent: 20),
                    ],
                    Feature::Jungle
                ),
            ]),
        };
    }
}
