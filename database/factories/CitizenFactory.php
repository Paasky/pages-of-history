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
            'culture_id' => fn(array $data) => Culture::factory()->create(
                ['player_id' => City::findOrFail($data['city_id'])->player_id]
            )->id,
            'religion_id' => null,
            'workplace_type' => null,
            'workplace_id' => null,
            'desire_yield' => YieldType::casesFor(new Citizen())->random(),
        ];
    }
}
