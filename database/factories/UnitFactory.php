<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Hex;
use App\Models\Map;
use App\Models\Player;
use App\Models\Region;
use App\Models\Unit;
use App\Models\UnitDesign;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Unit>
 */
class UnitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'player_id' => fn() => Player::factory()->create()->id,
            'hex_id' => function (array $data) {
                $player = Player::findOrFail($data['player_id']);
                $map = $player->map ?: Map::factory()->create();
                $region = $map->regions->first() ?: Region::factory()->create(['map_id' => $map->id]);
                $hex = $region->hexes->first() ?: Hex::factory()->create(['region_id' => $region->id]);
                return $hex->id;
            },
            'unit_design_id' => fn(array $data) => UnitDesign::factory()->create(['player_id' => $data['player_id']])->id,
            'city_id' => fn(array $data) => Player::findOrFail($data['player_id'])->cities->first()?->id
                ?: City::factory()->create([
                    'player_id' => $data['player_id'],
                    'hex_id' => $data['hex_id'],
                ])->id,
            'type' => fn(array $data) => UnitDesign::findOrFail($data['unit_design_id'])->type,
            'health' => random_int(1, 4) * 25,
            'moves_remaining' => 2,
        ];
    }
}
