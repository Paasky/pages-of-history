<?php

namespace Database\Factories;

use App\Enums\ArmorType;
use App\Enums\UnitType;
use App\Enums\WeaponType;
use App\Models\Map;
use App\Models\Player;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Unit>
 */
class UnitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'map_id' => Map::first() ?: Map::factory()->create()->id,
            'hex_id' => fn(array $data) => Map::findOrFail($data['map_id'])
                ->hexes()
                ->whereDoesntHave('units')
                ->inRandomOrder()
                ->firstOrFail()->id,
            'player_id' => fn(array $data) => Map::findOrFail($data['map_id'])
                ->players()
                ->inRandomOrder()
                ->first()?->id
                ?: Player::factory()->create(['map_id' => $data['map_id']])->id,
            'type' => $this->faker->randomElement(UnitType::cases()),
            'weapon' => function (array $data) {
                /** @var UnitType $unitType */
                $unitType = $data['type'];
                return $this->faker->randomElement($unitType->weapons());
            },
            'armor' => function (array $data) {
                /** @var UnitType $unitType */
                $unitType = $data['type'];
                return $this->faker->randomElement($unitType->armors());
            },
            'health' => random_int(1, 4) * 25,
        ];
    }
}
