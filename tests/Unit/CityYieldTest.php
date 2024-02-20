<?php


use App\Buildings\Training\ArcheryRange;
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
use App\Models\City;
use App\Models\Hex;
use App\Models\Religion;
use App\Models\UnitDesign;
use App\UnitEquipment\Ranged\Bow;
use App\UnitPlatforms\Person;
use App\Yields\YieldModifier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CityYieldTest extends TestCase
{
    use RefreshDatabase;

    public function testTwoCitizenBaseYields(): void
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

    public function testTwoCitizensFullYields(): void
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

    public function testTwoCitizenUnitBuildingWorkplace(): void
    {
        $city = City::factory()->create();

        $archeryRange = Building::factory()->create([
            'hex_id' => $city->hex_id,
            'type' => ArcheryRange::get(),
        ]);

        $hex = Hex::factory()->create([
            'region_id' => $city->hex->region_id,
            'x' => $city->hex->x + 1,
            'y' => $city->hex->y,
            'domain' => Domain::Land,
            'surface' => Surface::Grass,
            'feature' => Feature::Jungle,
            'improvement' => Shepard::get(),
        ]);

        $citizen1 = Citizen::factory()->create(['desire_yield' => YieldType::Gold, 'city_id' => $city->id]);
        $citizen2 = Citizen::factory()->create(['desire_yield' => YieldType::Food, 'city_id' => $city->id]);

        $citizen1->workplace()->associate($archeryRange);
        $citizen2->workplace()->associate($hex);
        $citizen1->save();
        $citizen2->save();

        // City isn't constructing anything

        // Exists: -2 food * 2
        // Exists: -1 health * 2
        // Exists: -1 happy * 2
        // Doesn't work with desired yield: -0.5 happy

        // Archery Range: +1 culture, -1 gold
        // Grass tile: +2 food
        // Jungle tile: +1 prod, +1 science, -20% health
        // Shepard tile: +0.5 food, +0.5 gold
        $this->assertEquals(
            collect([
                new YieldModifier($city, YieldType::Culture, 1),
                new YieldModifier($city, YieldType::Food, 2.5 - 4),
                new YieldModifier($city, YieldType::Gold, -0.5),
                new YieldModifier($city, YieldType::Happiness, -2.5),
                new YieldModifier($city, YieldType::Health, -2.2),
                new YieldModifier($city, YieldType::Production, 1),
                new YieldModifier($city, YieldType::Science, 1),
            ]),
            $city->yield_modifiers
        );

        // City is constructing a Bowman

        // Exists: -2 food * 2
        // Exists: -1 health * 2
        // Exists: -1 happy * 2
        // Doesn't work with desired yield: -0.5 happy

        // Archery Range: +1 culture, -1 gold, +25% prod for Ranged
        // Grass tile: +2 food
        // Jungle tile: +1 prod, +1 science, -20% health
        // Shepard tile: +0.5 food, +0.5 gold
        $city->production_queue->add(
            UnitDesign::factory()->create([
                'player_id' => $city->player_id,
                'platform' => Person::get(),
                'equipment' => Bow::get(),
            ])
        );
        $this->assertEquals(
            collect([
                new YieldModifier($city, YieldType::Culture, 1),
                new YieldModifier($city, YieldType::Food, 2.5 - 4),
                new YieldModifier($city, YieldType::Gold, -0.5),
                new YieldModifier($city, YieldType::Happiness, -2.5),
                new YieldModifier($city, YieldType::Health, -2.2),
                new YieldModifier($city, YieldType::Production, 1.25),
                new YieldModifier($city, YieldType::Science, 1),
            ]),
            $city->yield_modifiers
        );
    }
}
