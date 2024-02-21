<?php

namespace Database\Seeders;

use App\Map\MapGenerator;
use App\Models\Map;
use App\Models\Region;
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
            echo $map->height * $map->width;
            $i = 0;
            foreach ($generator->generatedRegions as $mapRegion) {
                /** @var Region $region */
                $region = $map->regions()->createQuietly([
                    'x' => $mapRegion->xy->x,
                    'y' => $mapRegion->xy->y,
                    'domain' => $mapRegion->domain->value,
                    'surface' => $mapRegion->surface->value,
                    'elevation' => $mapRegion->elevation,
                    'feature' => $mapRegion->feature?->value,
                ]);
                foreach ($mapRegion->hexes as $hex) {
                    $region->hexes()->saveQuietly($hex);
                }
                echo '.';
                $i++;
                if ($i === 100) {
                    echo '100' . PHP_EOL;
                    $i = 0;
                }
            }
        });
    }
}
