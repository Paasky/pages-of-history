<?php

namespace Tests\Unit;

use App\Enums\CultureTrait;
use App\Enums\CultureVice;
use App\Enums\CultureVirtue;
use App\Enums\Domain;
use App\Enums\Feature;
use App\Enums\ReligionTenet;
use App\Enums\Surface;
use App\Enums\YieldType;
use App\Improvements\Pastures\Shepard;
use App\Models\Citizen;
use App\Models\Hex;
use App\Models\Religion;
use App\Yields\YieldModifier;
use Tests\TestCase;

class YieldTest extends TestCase
{
    public function testCitizenYields(): void
    {
        // Exists: -2 food
        // Exists: -1 happy
        // No Work: -1 happy
        // Exists: -1 health
        // = -2 food, -2 happy, -1 health
        $citizen = Citizen::factory()->create(['desire_yield' => YieldType::Food]);

        $citizen->refresh();
        $this->assertEquals(
            collect([
                new YieldModifier(YieldType::Food, -2),
                new YieldModifier(YieldType::Happiness, -2),
                new YieldModifier(YieldType::Health, -1),
            ]),
            $citizen->yield_modifiers
        );

        // Exists: -2 food
        // Culture virtue: +10% food
        // Exists: -1 happy
        // No Work: -1 happy
        // Exists: -1 health
        // = -1.8 food, -2 happy, -1 health
        $citizen->culture->virtues = collect([CultureVirtue::Cooperative]);
        $citizen->culture->save();

        $citizen->refresh();
        $this->assertEquals(
            collect([
                new YieldModifier(YieldType::Food, -1.8),
                new YieldModifier(YieldType::Happiness, -2),
                new YieldModifier(YieldType::Health, -1),
            ]),
            $citizen->yield_modifiers
        );

        // Exists: -2 food
        // Grass tile: +2 food
        // Culture virtue: +10% food
        // Exists: -1 happy
        // Exists: -1 health
        // = +0.2 food, -1 happy, -1 health
        $workplace = Hex::factory()->create([
            'region_id' => $citizen->city->hex->region_id,
            'x' => $citizen->city->hex->x + 1,
            'y' => $citizen->city->hex->y,
            'domain' => Domain::Land,
            'surface' => Surface::Grass,
        ]);
        $citizen->workplace()->associate($workplace);
        $citizen->save();

        $citizen->refresh();
        $this->assertEquals(
            collect([
                new YieldModifier(YieldType::Food, 0.2),
                new YieldModifier(YieldType::Happiness, -1),
                new YieldModifier(YieldType::Health, -1),
            ]),
            $citizen->yield_modifiers
        );


        $workplace->feature = Feature::Jungle;
        $workplace->improvement = Shepard::get();
        $workplace->save();

        $citizen->culture->vices = collect([CultureVice::Corrupt]);
        $citizen->culture->save();
        $citizen->religion()->associate(Religion::factory()->create([
            'city_id' => $citizen->city_id,
            'tenets' => collect([ReligionTenet::Reformist])
        ]));
        $citizen->save();

        // Exists: -2 food
        // Exists: -1 happy
        // Exists: -1 health
        // Grass tile: +2 food
        // Jungle tile: +1 prod, +1 science, -20% health
        // Shepard tile: +0.5 food, +0.5 gold
        // Culture virtue: +10% food
        // Culture vice: -20% gold
        // Religion tenet: +10% science
        // City Owner doesn't follow Religion: -0.5 happy
        // = +0.75 food, -1 happy, +0.4 gold, -1.2 health, +1 prod, +1.1 science
        $citizen->refresh();
        $this->assertEquals(
            collect([
                new YieldModifier(YieldType::Food, 0.75),
                new YieldModifier(YieldType::Gold, 0.4),
                new YieldModifier(YieldType::Happiness, -1.5),
                new YieldModifier(YieldType::Health, -1.2),
                new YieldModifier(YieldType::Production, 1),
                new YieldModifier(YieldType::Science, 1.1),
            ]),
            $citizen->yield_modifiers
        );

        $citizen->culture->traits = collect([CultureTrait::Tropical, CultureTrait::Nomadic]);
        $citizen->culture->save();

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
                new YieldModifier(YieldType::Food, round(3.5 * 1.1 - 2, 2)),
                new YieldModifier(YieldType::Gold, round(1.5 * 0.8, 2)),
                new YieldModifier(YieldType::Happiness, -1.5),
                new YieldModifier(YieldType::Health, -1),
                new YieldModifier(YieldType::Production, 1),
                new YieldModifier(YieldType::Science, 1.1),
            ]),
            $citizen->yield_modifiers
        );
    }
}
