<?php

use App\Enums\Domain;
use App\Enums\UnitEquipmentCategory;
use App\Enums\YieldType;
use App\Models\Hex;
use App\Models\Unit;
use App\Models\UnitDesign;
use App\UnitArmor\Person\WoodShield;
use App\UnitEquipment\Melee\BronzeSword;
use App\UnitPlatforms\Mounted\Horseback;
use App\UnitPlatforms\Person;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersTowards;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnitYieldTest extends TestCase
{
    use RefreshDatabase;

    public function testUnitBaseYields(): void
    {
        $unit = Unit::factory()->create([
            'hex_id' => Hex::factory()->create(['domain' => Domain::Land]),
            'unit_design_id' => UnitDesign::factory()->create([
                'platform' => Horseback::get(),
                'equipment' => BronzeSword::get(),
                'armor' => WoodShield::get(),
            ])->id,
        ]);

        // Horseback: cost +50%, moves 3
        // Bronze Sword: 25 cost, 7 strength, +10% strength vs Person
        // Wood Shield: +50% cost, 1 strength, +10% strength vs Melee
        // ModifiersFor/Against are not combined
        $this->assertEquals(
            collect([
                new YieldModifier($unit, YieldType::Cost, 50),
                new YieldModifier($unit, YieldType::Moves, 3),
                new YieldModifier($unit, YieldType::Strength, 8),
                new YieldModifiersTowards(
                    new YieldModifier(BronzeSword::get(), YieldType::Strength, percent: 10),
                    Person::get()
                ),
                new YieldModifiersTowards(
                    new YieldModifier(WoodShield::get(), YieldType::Strength, percent: 10),
                    UnitEquipmentCategory::Melee
                ),
            ]),
            $unit->yield_modifiers
        );
    }

    public function testUnitVsUni(): void
    {
        $unit1 = Unit::factory()->create([
            'hex_id' => Hex::factory()->create(['domain' => Domain::Land]),
            'unit_design_id' => UnitDesign::factory()->create([
                'platform' => Horseback::get(),
                'equipment' => BronzeSword::get(),
                'armor' => WoodShield::get(),
            ])->id,
        ]);
        $unit2 = Unit::factory()->create([
            'hex_id' => Hex::factory()->create(['domain' => Domain::Land, 'x' => $unit1->hex->x, 'y' => $unit1->hex->y + 1]),
            'unit_design_id' => UnitDesign::factory()->create([
                'platform' => Person::get(),
                'equipment' => BronzeSword::get(),
                'armor' => null,
            ])->id,
        ]);

        // Horseback: cost +50%, moves 3
        // Bronze Sword: 25 cost, 7 strength, +10% strength vs Person
        // Wood Shield: +50% cost, 1 strength, +10% strength vs Melee
        $this->assertEquals(
            collect([
                new YieldModifier($unit1, YieldType::Cost, 50),
                new YieldModifier($unit1, YieldType::Moves, 3),
                new YieldModifier($unit1, YieldType::Strength, 9.6),
            ]),
            $unit1->getYieldModifiersAttribute($unit2)
        );

        // Person: moves 2
        // Bronze Sword: 25 cost, 7 strength, +10% strength vs Person
        $this->assertEquals(
            collect([
                new YieldModifier($unit2, YieldType::Cost, 25),
                new YieldModifier($unit2, YieldType::Moves, 2),
                new YieldModifier($unit2, YieldType::Strength, 7),
            ]),
            $unit2->getYieldModifiersAttribute($unit1)
        );
    }
}
