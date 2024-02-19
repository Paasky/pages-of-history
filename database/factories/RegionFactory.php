<?php

namespace Database\Factories;

use App\Enums\Domain;
use App\Enums\Surface;
use App\Models\Map;
use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Region>
 */
class RegionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'map_id' => fn() => Map::first() ?: Map::factory()->create(),
            'x' => 0,
            'y' => 0,
            'domain' => \Arr::random(Domain::cases()),
            'surface' => fn(array $data) => $data['domain'] === Domain::Land ? Surface::Grass : Surface::Ocean,
            'elevation' => 0,
            'feature' => null,
        ];
    }
}
