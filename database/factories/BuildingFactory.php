<?php

namespace Database\Factories;

use App\Buildings\BuildingType;
use App\Models\Building;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Building>
 */
class BuildingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hex_id' => fn() => City::factory()->create()->hex_id,
            'type' => BuildingType::all()->random(),
            'health' => 100,
        ];
    }
}
