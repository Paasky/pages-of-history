<?php

namespace Database\Factories;

use App\Enums\YieldType;
use App\Models\Citizen;
use App\Models\City;
use App\Models\Culture;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Citizen>
 */
class CitizenFactory extends Factory
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
            'culture_id' => function (array $data) {
                $player = City::findOrFail($data['city_id'])->player;
                return $player->culture()->first()
                    ?: Culture::factory()->create(
                        ['player_id' => $player->id]
                    )->id;
            },
            'religion_id' => null,
            'workplace_type' => null,
            'workplace_id' => null,
            'desire_yield' => YieldType::casesFor(new Citizen())->random(),
        ];
    }
}
