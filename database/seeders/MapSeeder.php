<?php

namespace Database\Seeders;

use App\Map\MapGenerator;
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
        $map = Map::factory(['height' => $generator->worldRegionsY, 'width' => $generator->worldRegionsX])->create();
        foreach ($generator->generatedRegions as $region) {
            $map->regions()->create([
                'x' => $region->xy->x,
                'y' => $region->xy->y,
                'domain' => $region->domain,
                'surface' => $region->surface,
                'elevation' => $region->elevation,
                'feature' => $region->feature,
            ]);
        }
    }
}
