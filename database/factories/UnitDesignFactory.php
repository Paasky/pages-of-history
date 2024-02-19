<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\UnitDesign;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UnitDesign>
 */
class UnitDesignFactory extends Factory
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
            'name' => $this->faker->firstName,
            'platform' => UnitPlatformType::all()->random(),
            'equipment' => fn(array $data) => $data['platform']->equipment()->random(),
            'armor' => null,
            'type' => fn(array $data) => $data['equipment']->unitType(),
        ];
    }
}
