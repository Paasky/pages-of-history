<?php

namespace Database\Factories;

use App\Models\Map;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
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
            'map_id' => Map::first() ?: Map::factory()->create()->id,
            'user_id' => null,
            'color1' => $this->faker->hexColor(),
            'color2' => $this->faker->unique()->hexColor(),
        ];
    }
}
