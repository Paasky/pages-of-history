<?php

namespace App\Buildings;

use App\AbstractType;
use App\Enums\BuildingCategory;
use App\Enums\Domain;
use App\Enums\ImprovementCategory;
use App\Enums\TechnologyEra;
use App\Enums\UnitPlatformCategory;
use App\Enums\YieldType;
use App\GameConcept;
use App\Resources\ResourceType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use App\Yields\YieldModifiersTowards;
use Illuminate\Support\Collection;

abstract class BuildingType extends AbstractType
{
    /**
     * @return Collection<int, BuildingType>
     */
    public static function all(): Collection
    {
        return static::instances(
            app_path('Buildings'),
            [BuildingType::class]
        );
    }

    public function icon(): string
    {
        return $this->category()->icon();
    }

    abstract public function category(): BuildingCategory;

    /** @return Collection<int, GameConcept> */
    public function requires(): Collection
    {
        return collect([
            $this->technology(),
            ... $this->resources()
        ])->filter()->values();
    }

    /**
     * @return Collection<int, ResourceType>
     */
    public function resources(): Collection
    {
        return collect();
    }

    public function yieldModifiers(): Collection
    {
        $era = $this->technology()?->era() ?: TechnologyEra::Neolithic;
        $amount = $era->baseYield();
        $halfAmount = max(1, round($era->baseYield() / 2));
        $thirdAmount = max(1, round($era->baseYield() / 3));

        $modifiers = collect([new YieldModifier($this, YieldType::Cost, $era->baseCost())]);
        if (!in_array($this->category(), [BuildingCategory::Gold, BuildingCategory::LandTrade, BuildingCategory::SeaTrade])) {
            $modifiers->push(new YieldModifier($this, YieldType::Gold, -$thirdAmount));
        }

        return $modifiers->merge([
            ...match ($this->category()) {
                BuildingCategory::Defense => [new YieldModifier($this, YieldType::Defense, $era->baseStrength())],
                BuildingCategory::Faith => [new YieldModifier($this, YieldType::Faith, $amount)],
                BuildingCategory::Food => [new YieldModifier($this, YieldType::Food, $amount + 2)],
                BuildingCategory::Gold => [new YieldModifier($this, YieldType::Gold, $amount)],
                BuildingCategory::Happiness => [new YieldModifier($this, YieldType::Happiness, $amount)],
                BuildingCategory::Health => [new YieldModifier($this, YieldType::Health, $amount)],
                BuildingCategory::Production => [new YieldModifier($this, YieldType::Production, $amount)],
                BuildingCategory::Culture => [new YieldModifier($this, YieldType::Culture, $amount)],
                BuildingCategory::Science => [new YieldModifier($this, YieldType::Science, $amount)],
                BuildingCategory::AirTrade => [
                    new YieldModifiersFor(
                        [
                            new YieldModifier($this, YieldType::Capacity, $thirdAmount),
                            new YieldModifier($this, YieldType::Trade, $halfAmount),
                        ],
                        Domain::Air
                    ),
                ],
                BuildingCategory::AirTraining => [
                    new YieldModifiersFor(
                        new YieldModifier($this, YieldType::Capacity, $halfAmount),
                        Domain::Air
                    ),
                    new YieldModifiersTowards(
                        new YieldModifier($this, YieldType::Production, percent: 25),
                        Domain::Air
                    ),
                ],
                BuildingCategory::LandTrade => [
                    new YieldModifier($this, YieldType::Gold, $halfAmount),
                    new YieldModifiersFor(
                        new YieldModifier($this, YieldType::Trade, $halfAmount),
                        Domain::Land
                    ),
                ],
                BuildingCategory::LandTraining => [
                    new YieldModifier($this, YieldType::Happiness, $halfAmount),
                    new YieldModifiersTowards(
                        new YieldModifier($this, YieldType::Production, percent: 25),
                        Domain::Land
                    ),
                ],
                BuildingCategory::SeaTrade => [
                    new YieldModifiersFor(
                        new YieldModifier($this, YieldType::Gold, $thirdAmount),
                        ImprovementCategory::Fisheries
                    ),
                    new YieldModifiersFor(
                        new YieldModifier($this, YieldType::Trade, $halfAmount),
                        Domain::Water
                    ),
                ],
                BuildingCategory::SeaTraining => [
                    new YieldModifiersFor(
                        new YieldModifier($this, YieldType::Production, $thirdAmount),
                        ImprovementCategory::Fisheries
                    ),
                    new YieldModifiersTowards(
                        new YieldModifier($this, YieldType::Production, percent: 25),
                        UnitPlatformCategory::Naval
                    ),
                ],
            },
        ]);
    }
}
