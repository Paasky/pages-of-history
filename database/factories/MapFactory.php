<?php

namespace Database\Factories;

use App\Managers\MapManager;
use App\Models\Map;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Map>
 */
class MapFactory extends Factory
{
    public function definition(): array
    {
        return [
            'height' => random_int(10, 20),
            'width' => random_int(10, 20),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Map $map) {
            MapManager::for($map)->generateHexes();
        });
    }
}
