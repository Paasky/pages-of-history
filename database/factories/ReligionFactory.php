<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Religion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Religion>
 */
class ReligionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'city_id' => fn() => City::factory()->create(),
            'name' => $this->faker->firstName . 'ism',
            'tenets' => [],
        ];
    }
}
