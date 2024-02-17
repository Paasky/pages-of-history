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
        $amount = floor($era->baseArmorStrength() / 2) + 1;

        return collect([
            new YieldModifier($this, YieldType::Cost, $era->baseCost()),
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
                            new YieldModifier($this, YieldType::Capacity, ceil($era->baseArmorStrength() / 4)),
                            new YieldModifier($this, YieldType::Trade, floor($era->baseArmorStrength() / 2)),
                        ],
                        Domain::Air
                    ),
                ],
                BuildingCategory::AirTraining => [
                    new YieldModifiersFor(
                        [
                            new YieldModifier($this, YieldType::Capacity, ceil($era->baseArmorStrength() / 4)),
                            new YieldModifier($this, YieldType::Production, percent: floor($era->baseArmorStrength() / 2) * 10),
                        ],
                        Domain::Air
                    ),
                ],
                BuildingCategory::LandTrade => [
                    new YieldModifiersFor(
                        new YieldModifier($this, YieldType::Trade, floor($era->baseArmorStrength() / 2)),
                        Domain::Land
                    ),
                ],
                BuildingCategory::LandTraining => [
                    new YieldModifiersFor(
                        new YieldModifier($this, YieldType::Production, percent: floor($era->baseArmorStrength() / 2) * 10),
                        Domain::Land
                    ),
                ],
                BuildingCategory::SeaTrade => [
                    new YieldModifiersFor(
                        new YieldModifier($this, YieldType::Production, ceil($era->baseArmorStrength() / 2)),
                        ImprovementCategory::Fisheries
                    ),
                    new YieldModifiersFor(
                        new YieldModifier($this, YieldType::Trade, floor($era->baseArmorStrength() / 2)),
                        Domain::Water
                    ),
                ],
                BuildingCategory::SeaTraining => [
                    new YieldModifiersFor(
                        new YieldModifier($this, YieldType::Gold, ceil($era->baseArmorStrength() / 2)),
                        ImprovementCategory::Fisheries
                    ),
                    new YieldModifiersFor(
                        new YieldModifier($this, YieldType::Production, percent: floor($era->baseArmorStrength() / 2) * 10),
                        UnitPlatformCategory::Naval
                    ),
                ],
            },
        ]);
    }
}
