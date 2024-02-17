<?php

namespace Tests\Unit;

use App\Buildings\Food\Granary;
use App\Buildings\Training\Stables;
use App\Enums\CultureTrait;
use App\Enums\CultureVice;
use App\Enums\CultureVirtue;
use App\Enums\Domain;
use App\Enums\Feature;
use App\Enums\ReligionTenet;
use App\Enums\Surface;
use App\Enums\YieldType;
use App\Improvements\Pastures\Shepard;
use App\Models\Building;
use App\Models\Citizen;
use App\Models\Hex;
use App\Models\Religion;
use App\Yields\YieldModifier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CitizenYieldTest extends TestCase
{
    use RefreshDatabase;

    public function testCitizenBaseYields(): void
    {
        $citizen = Citizen::factory()->create(['desire_yield' => YieldType::Food]);

        // Exists: -2 food
        // Exists: -1 happy
        // No Work: -1 happy
        // Exists: -1 health
        // = -2 food, -2 happy, -1 health
        $this->assertEquals(
            collect([
                new YieldModifier($citizen, YieldType::Food, -2),
                new YieldModifier($citizen, YieldType::Happiness, -2),
                new YieldModifier($citizen, YieldType::Health, -1),
            ]),
            $citizen->yield_modifiers
        );
    }

    public function testCitizenCulturePercentChangesNegativeYield(): void
    {
        $citizen = Citizen::factory()->create(['desire_yield' => YieldType::Food]);

        $citizen->culture->virtues = collect([CultureVirtue::Cooperative]);
        $citizen->culture->save();
        $citizen->refresh();

        // Exists: -2 food
        // Culture virtue: +10% food
        // Exists: -1 happy
        // No Work: -1 happy
        // Exists: -1 health
        // = -1.8 food, -2 happy, -1 health
        $this->assertEquals(
            collect([
                new YieldModifier($citizen, YieldType::Food, -1.8),
                new YieldModifier($citizen, YieldType::Happiness, -2),
                new YieldModifier($citizen, YieldType::Health, -1),
            ]),
            $citizen->yield_modifiers
        );
    }

    public function testCitizenAmountsCancelOutAndNegativePercentYields(): void
    {
        $citizen = Citizen::factory()->create(['desire_yield' => YieldType::Food]);

        $workplace = Hex::factory()->create([
            'region_id' => $citizen->city->hex->region_id,
            'x' => $citizen->city->hex->x + 1,
            'y' => $citizen->city->hex->y,
            'domain' => Domain::Land,
            'surface' => Surface::Grass,
            'feature' => Feature::Jungle,
        ]);
        $citizen->workplace()->associate($workplace);
        $citizen->save();

        // Exists: -2 food
        // Exists: -1 happy
        // Exists: -1 health
        // Grass tile: +2 food
        // Jungle tile: +1 prod, +1 science, -20% health
        // = -1 happy, -1.2 health, +1 prod, +1 science
        $citizen->refresh();
        $this->assertEquals(
            collect([
                new YieldModifier($citizen, YieldType::Happiness, -1),
                new YieldModifier($citizen, YieldType::Health, -1.2),
                new YieldModifier($citizen, YieldType::Production, 1),
                new YieldModifier($citizen, YieldType::Science, 1),
            ]),
            $citizen->yield_modifiers
        );
    }

    public function testCitizenFullYields(): void
    {
        $citizen = Citizen::factory()->create(['desire_yield' => YieldType::Food]);

        $workplace = Hex::factory()->create([
            'region_id' => $citizen->city->hex->region_id,
            'x' => $citizen->city->hex->x + 1,
            'y' => $citizen->city->hex->y,
            'domain' => Domain::Land,
            'surface' => Surface::Grass,
            'feature' => Feature::Jungle,
            'improvement' => Shepard::get(),
        ]);
        $citizen->workplace()->associate($workplace);

        $citizen->culture->traits = collect([CultureTrait::Tropical, CultureTrait::Nomadic]);
        $citizen->culture->vices = collect([CultureVice::Corrupt]);
        $citizen->culture->virtues = collect([CultureVirtue::Cooperative]);
        $citizen->culture->save();

        $citizen->religion()->associate(Religion::factory()->create([
            'city_id' => $citizen->city_id,
            'tenets' => collect([ReligionTenet::Reformist])
        ]));

        $citizen->save();

        // Exists: -2 food
        // Exists: -1 health
        // Exists: -1 happy
        // City Owner doesn't follow Religion: -0.5 happy

        // Grass tile: +2 food
        // Jungle tile: +1 prod, +1 science, -20% health
        // Shepard tile: +0.5 food, +0.5 gold

        // Culture traits: +20% health in jungle, +1 food in jungle, +1 gold for Pastures
        // Culture virtue: +10% food
        // Culture vice: -20% gold

        // Religion tenet: +10% science
        // = +1.85 food, +1.2 gold, -1.5 happy, -1 health, +1 prod, +1.1 science
        $citizen->refresh();
        $this->assertEquals(
            collect([
                new YieldModifier($citizen, YieldType::Food, round(3.5 * 1.1 - 2, 2)),
                new YieldModifier($citizen, YieldType::Gold, round(1.5 * 0.8, 2)),
                new YieldModifier($citizen, YieldType::Happiness, -1.5),
                new YieldModifier($citizen, YieldType::Health, -1),
                new YieldModifier($citizen, YieldType::Production, 1),
                new YieldModifier($citizen, YieldType::Science, 1.1),
            ]),
            $citizen->yield_modifiers
        );
    }

    public function testCitizenBuildingWorkplace(): void
    {
        $citizen = Citizen::factory()->create(['desire_yield' => YieldType::Food]);

        $workplace = Building::factory()->create([
            'hex_id' => $citizen->city->hex_id,
            'type' => Granary::get(),
        ]);
        $citizen->workplace()->associate($workplace);
        $citizen->save();

        // Exists: -2 food
        // Exists: -1 happy
        // Exists: -1 health
        // Granary: +3 food
        // = +1 food, -1 happy, -1 health
        $this->assertEquals(
            collect([
                new YieldModifier($citizen, YieldType::Food, 1),
                new YieldModifier($citizen, YieldType::Happiness, -1),
                new YieldModifier($citizen, YieldType::Health, -1),
            ]),
            $citizen->yield_modifiers
        );
    }

    public function testCitizenUnitBuildingWorkplace(): void
    {
        $citizen = Citizen::factory()->create(['desire_yield' => YieldType::Food]);

        $workplace = Building::factory()->create([
            'hex_id' => $citizen->city->hex_id,
            'type' => Stables::get(),
        ]);
        $citizen->workplace()->associate($workplace);
        $citizen->save();

        // Exists: -2 food
        // Exists: -1 happy
        // Exists: -1 health
        // Not working with desired yield: -0.5 happy
        // Stables: no effect
        // = -2 food, -1.5 happy, -1 health
        $this->assertEquals(
            collect([
                new YieldModifier($citizen, YieldType::Food, -2),
                new YieldModifier($citizen, YieldType::Happiness, -1.5),
                new YieldModifier($citizen, YieldType::Health, -1),
            ]),
            $citizen->yield_modifiers
        );
    }
}
