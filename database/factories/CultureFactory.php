<?php

namespace Database\Factories;

use App\Models\Culture;
use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Culture>
 */
class CultureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'player_id' => fn() => Player::factory()->create(),
            'name' => $this->faker->country . 'ian',
            'traits' => [],
            'vices' => [],
            'virtues' => [],
        ];
    }
}
