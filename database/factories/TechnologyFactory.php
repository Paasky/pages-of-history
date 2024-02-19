<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\Technology;
use App\Technologies\TechnologyType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Technology>
 */
class TechnologyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'player_id' => fn() => Player::factory()->create()->id,
            'type' => TechnologyType::all()->random(),
            'is_known' => $this->faker->boolean,
            'research' => fn(array $data) => round($data['type']->cost() * ($data['is_known'] ? 1 : 0.5)),
        ];
    }
}
