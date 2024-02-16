<?php

namespace Database\Seeders;

use App\Map\MapGenerator;
use App\Map\MapRegion;
use App\Models\Map;
use Illuminate\Database\Seeder;

class MapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $generator = new MapGenerator();
        $generator->generate();
        \DB::transaction(function () use ($generator) {
            $map = Map::factory(['height' => $generator->worldRegionsY, 'width' => $generator->worldRegionsX])->create();
            $map->regions()->insert(array_map(
                fn(MapRegion $region) => [
                    'map_id' => $map->id,
                    'x' => $region->xy->x,
                    'y' => $region->xy->y,
                    'domain' => $region->domain->value,
                    'surface' => $region->surface->value,
                    'elevation' => $region->elevation,
                    'feature' => $region->feature?->value,
                ],
                $generator->generatedRegions
            ));
        });
    }
}
