<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Hex;
use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hex_id' => fn() => Hex::factory()->create(),
            'player_id' => fn(array $data) => Player::factory()->create(
                ['map_id' => Hex::findOrFail($data['hex_id'])->region->map_id]
            ),
            'name' => $this->faker->city,
            'health' => 100,
        ];
    }
}
