<?php

namespace Database\Factories;

use App\Models\Map;
use App\Models\Player;
use App\Models\UnitDesign;
use App\Models\User;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitName;
use App\UnitPlatforms\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'map_id' => fn() => Map::first() ?: Map::factory()->create()->id,
            'user_id' => fn() => User::factory()->create()->id,
            'color1' => $this->faker->hexColor(),
            'color2' => $this->faker->unique()->hexColor(),
        ];
    }

    public function withInitialUnitDesigns(): self
    {
        return $this->afterCreating(function (Player $player) {
            $equipmentTypes = UnitEquipmentType::all()->filter(fn(UnitEquipmentType $type) => !$type->technology());
            foreach ($equipmentTypes as $equipment) {
                UnitDesign::factory()->create([
                    'player_id' => $player->id,
                    'name' => UnitName::name(Person::get(), $equipment, null),
                    'platform' => Person::get(),
                    'equipment' => $equipment,
                    'armor' => null,
                    'type' => $equipment->unitType(),
                ]);
            }
        });
    }
}
