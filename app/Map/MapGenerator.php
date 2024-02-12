<?php

namespace App\Map;

use App\Coordinate;
use App\Enums\Domain;
use App\Enums\Feature;
use App\Enums\Surface;
use Illuminate\Support\Arr;

class MapGenerator
{
    public int $worldRegionsX = 120;
    public int $worldRegionsY = 60;
    public float $waterVsLandDistribution = 0.6;
    public float $initialOceansOrContinents = 7;
    public float $faultLinesMultiplier = 2;
    public float $faultLinesLength = 4;
    public float $faultLineDirections = 2;
    public float $maxOceanIslandChain = 2;

    /** @var Region[] */
    public array $generatedRegions = [];
    public array $generatedContinents = [];
    public array $generatedOceans = [];

    public function generate(): self
    {
        $this->generatedRegions = [];
        $this->generatedContinents = [];
        $this->generatedOceans = [];

        $this
            // Domain, Continents, Lakes, Oceans
            ->generateRegions()
            // Height
            ->generateFaultLines()
            ->smoothHeights()
            // Surfaces
            ->generateSurfaces()
            // Features
            ->generateFeatures()
            // Get rid of any randomness that's not allowed
            ->postProcess()
            ->draw()
        ;
        return $this;
    }

    protected function generateRegions(): self
    {
        /** @var Region[] $regionsToGenerate */
        $regionsToGenerate = [];
        foreach (range(0, $this->worldRegionsX - 1) as $x) {
            foreach (range(0, $this->worldRegionsY - 1) as $y) {
                $region = new Region(new Coordinate($x, $y));
                $regionsToGenerate[$region->key()] = $region;
            }
        }
        $waterRegionsLeft = round(count($regionsToGenerate) * $this->waterVsLandDistribution);
        $landRegionsLeft = count($regionsToGenerate) - $waterRegionsLeft;
        $continentsLeft = round($this->initialOceansOrContinents);
        $oceansLeft = round($this->initialOceansOrContinents);

        while ($regionsToGenerate) {
            /** @var Region $region */
            $region = Arr::random($regionsToGenerate);

            switch (true) {
                // Region is top or bottom row: must be water
                case in_array($region->xy->y, [0, $this->worldRegionsY - 1]):
                    $region->domain = Domain::Water;
                    $region->height = -5;
                    break;

                // Region is 2nd top or 2nd bottom row: 33% chance of land
                case in_array($region->xy->y, [1, $this->worldRegionsY - 2]):
                    $region->domain = rand(0, 2) ? Domain::Water : Domain::Land;
                    $region->height = $region->domain === Domain::Water
                        ? (rand(0, 1) ? 0 : -5)
                        : 0;
                    break;

                // Generating initial continents
                // Generate 1st 5 continents, then 1st 4 oceans, then the rest
                case $continentsLeft && (count($this->generatedContinents) < 5 || count($this->generatedOceans) >= 4):
                    // First 5 continents are in four corners of the map
                    if (count($this->generatedContinents) < 5) {
                        $thirdX = round($this->worldRegionsX / 3);
                        $fourthX = round($this->worldRegionsX / 4);
                        $fourthY = round($this->worldRegionsY / 4);
                        $newRegion = match (count($this->generatedContinents)) {
                            0 => $regionsToGenerate[(new Coordinate($thirdX, $fourthY))->key()] ?? null,
                            1 => $regionsToGenerate[(new Coordinate($thirdX, $fourthY * 3))->key()] ?? null,
                            2 => $regionsToGenerate[(new Coordinate($thirdX * 2, $fourthY))->key()] ?? null,
                            3 => $regionsToGenerate[(new Coordinate($thirdX * 2, $fourthY * 3))->key()] ?? null,
                            4 => $regionsToGenerate[(new Coordinate($fourthX * (rand(0, 1) ? 1 : 3), $fourthY * 2))->key()] ?? null,
                        };
                        if ($newRegion) {
                            $region = $newRegion;
                        }
                    }
                    $region->domain = Domain::Land;
                    $region->height = -2;
                    $continent = "Continent " . (count($this->generatedContinents) + 1);
                    $this->generatedContinents[] = $region->group = $continent;
                    $continentsLeft--;

                    // Generate each neighbor
                    $this->forEachNeighbor(
                        $region,
                        function (Region|string $neighbor)
                        use (&$regionsToGenerate, $region, &$landRegionsLeft) {
                            // Already generated
                            if ($neighbor instanceof Region) {
                                return;
                            }

                            $neighbor = $regionsToGenerate[$neighbor];
                            $neighbor->domain = Domain::Land;
                            $neighbor->group = $region->group;

                            // Lakes have a 1/3 chance to spread
                            if (!rand(0, 2)) {
                                $neighbor->height = -1;
                            }

                            $this->generatedRegions[$neighbor->key()] = $neighbor;
                            unset($regionsToGenerate[$neighbor->key()]);
                            $landRegionsLeft--;
                        },
                        round($this->worldRegionsY / 10)
                    );
                    break;

                // Generating initial oceans
                case $oceansLeft:
                    // First 3 oceans are in the middle of the map
                    if (count($this->generatedOceans) < 4) {
                        $halfX = round($this->worldRegionsX / 2);
                        $fourthY = round($this->worldRegionsY / 5);
                        $newRegion = match (count($this->generatedOceans)) {
                            0 => $regionsToGenerate[(new Coordinate($halfX, $fourthY))->key()] ?? null,
                            1 => $regionsToGenerate[(new Coordinate($halfX, $fourthY * 2))->key()] ?? null,
                            2 => $regionsToGenerate[(new Coordinate($halfX, $fourthY * 3))->key()] ?? null,
                            3 => $regionsToGenerate[(new Coordinate($halfX, $fourthY * 4))->key()] ?? null,
                        };
                        if ($newRegion) {
                            $region = $newRegion;
                        }
                    }
                    $region->domain = Domain::Water;
                    $region->height = -5;
                    $ocean = "Ocean " . (count($this->generatedOceans) + 1);
                    $this->generatedOceans[] = $region->group = $ocean;
                    $oceansLeft--;

                    // Generate each neighbor
                    $this->forEachNeighbor(
                        $region,
                        function (Region|string $neighbor)
                        use (&$regionsToGenerate, $region, &$waterRegionsLeft) {
                            // Already generated
                            if ($neighbor instanceof Region) {
                                return;
                            }

                            $neighbor = $regionsToGenerate[$neighbor];
                            $neighbor->domain = Domain::Water;
                            $neighbor->group = $region->group;

                            // Oceans always spread to neighbors
                            $neighbor->height = -5;

                            $this->generatedRegions[$neighbor->key()] = $neighbor;
                            unset($regionsToGenerate[$neighbor->key()]);
                            $waterRegionsLeft--;
                        },
                        round($this->worldRegionsY / 10)
                    );
                    break;

                // Default behaviour: Use regions left and neighbors as odds
                default:
                    $landNeighbors = 0;
                    $hasOceanNeighbor = false;
                    $possibleGroups = [];
                    $this->forEachNeighbor(
                        $region,
                        function (Region|string $neighbor) use (&$landNeighbors, &$hasOceanNeighbor, &$possibleGroups) {
                            if ($neighbor instanceof Region) {
                                if ($neighbor->domain === Domain::Land) {
                                    $landNeighbors++;
                                }
                                if ($neighbor->group) {
                                    $possibleGroups[$neighbor->domain->name][] = $neighbor->group;
                                }
                                if ($neighbor->domain == Domain::Water && $neighbor->height < 0) {
                                    $hasOceanNeighbor = true;
                                }
                            }
                        }
                    );

                    $region->domain = match (true) {
                        !$waterRegionsLeft => Domain::Land,
                        !$landRegionsLeft => Domain::Water,
                        default => rand(0, $landNeighbors)
                            ? Domain::Land
                            : Domain::Water
                    };
                    $region->group = Arr::random($possibleGroups[$region->domain->name] ?? ['']);
                    $region->height = match (true) {
                        $region->domain === Domain::Land => 0,
                        $hasOceanNeighbor => rand(0, $landNeighbors) ? 0 : -5,
                        default => $landNeighbors ? 0 : -5
                    };
            }
            $region->domain === Domain::Land
                ? $landRegionsLeft--
                : $waterRegionsLeft--;
            $this->generatedRegions[$region->key()] = $region;
            unset($regionsToGenerate[$region->key()]);
        }
        ksort($this->generatedRegions);
        return $this;
    }

    protected function generateFaultLines(): self
    {
        $faultLinesLeft = round($this->worldRegionsY * $this->faultLinesMultiplier);
        $notAllowedTurns = [
            'n' => ['sw', 's', 'se'],
            'ne' => ['w', 'sw', 's'],
            'e' => ['nw', 'w', 'sw'],
            'se' => ['n', 'nw', 'w'],
            's' => ['ne', 'n', 'nw'],
            'sw' => ['e', 'ne', 'n'],
            'w' => ['se', 'e', 'ne'],
            'nw' => ['s', 'se', 'e'],
        ];
        while ($faultLinesLeft) {
            $region = Arr::random($this->generatedRegions);

            $prevDirection = '';
            $directions = $this->faultLineDirections;
            while ($directions) {
                $direction = collect(
                    match (true) {
                        $region->xy->y < 2 => ['w', 'sw', 's', 'se', 'e'],
                        $region->xy->y > $this->worldRegionsY - 3 => ['w', 'nw', 'n', 'ne', 'e'],
                        default => ['n', 'ne', 'se', 's', 'sw', 'nw'],
                    }
                )->filter(
                    fn($d) => $d !== $prevDirection && !in_array($d, $notAllowedTurns[$prevDirection] ?? [])
                )->random();

                $region = $this->buildFaultLine($region, $direction);
                $prevDirection = $direction;
                $directions--;
            }
            $faultLinesLeft--;
        }

        return $this;
    }

    protected function buildFaultLine(Region $region, string $direction): Region
    {
        $oceanSteps = 0;
        for ($step = 1; $step <= $this->faultLinesLength; $step++) {
            if (!$region->height) {
                $region->height = $region->domain === Domain::Water ? 5 : 9;
            }
            if ($region->domain === Domain::Water && $region->height < 0 && rand(0, 1)) {
                $region->height = 5;
                $oceanSteps++;
            }

            $this->generatedRegions[$region->key()] = $region;

            if ($oceanSteps >= $this->maxOceanIslandChain) {
                break;
            }

            // Do the steps
            $nextXy = clone $region->xy;
            if (stristr($direction, 'n')) {
                $nextXy->y--;
            }
            if (stristr($direction, 'e')) {
                $nextXy->x++;
            }
            if (stristr($direction, 's')) {
                $nextXy->y++;
            }
            if (stristr($direction, 'w')) {
                $nextXy->x--;
            }
            $nextXy = $this->validCoords($nextXy);
            if (!$nextXy) {
                break;
            }

            $region = $this->generatedRegions[$nextXy->key()];
        }
        return $region;
    }

    protected function smoothHeights(): self
    {
        $newHeights = [];
        foreach ($this->generatedRegions as $key => $region) {
            $neighborHeights = [];
            $this->forEachNeighbor($region, function (Region $neighbor) use (&$neighborHeights) {
                $neighborHeights[] = $neighbor->height;
            });
            $neighborAvg = (array_sum($neighborHeights) / count($neighborHeights));
            $newHeights[$key] = round(($region->height + $neighborAvg) / 2);
        }

        foreach ($this->generatedRegions as $key => $region) {
            $region->height = $newHeights[$key];
            $this->generatedRegions[$key] = $region;
        }

        return $this;
    }

    protected function generateSurfaces(): self
    {
        // 1) Generate Climates by latitude
        $twentieth = $this->worldRegionsY / 20;
        $climates = [
            // Top row is Snow
            [0, Surface::Snow],
            // Next 2 rows are Tundra
            [2, Surface::Tundra],
            [(int)round($twentieth * 5), Surface::Grass],
            [(int)round($twentieth * 7), Surface::Plains],
            [(int)round($twentieth * 9), Surface::Desert],
            [(int)round($twentieth * 15), Surface::Grass],
            // Leave 3 bottom rows for Tundra & Snow
            [$this->worldRegionsY - 4, Surface::Plains],
            // Next two rows are Tundra
            [$this->worldRegionsY - 2, Surface::Tundra],
            // Should be one row left as Snow
            [$this->worldRegionsY, Surface::Snow],
        ];
        foreach ($this->generatedRegions as $region) {
            if ($region->domain === Domain::Water && $region->height <= 0) {
                $region->surface = Surface::Ocean;
                $this->generatedRegions[$region->key()] = $region;
                continue;
            }
            foreach ($climates as $key => $climate) {
                [$maxY, $surface] = $climate;
                if ($region->xy->y <= $maxY) {
                    $surfaces = [$surface];
                    if ($prevClimate = $climates[$key - 1] ?? null) {
                        [$maxY, $surface] = $prevClimate;
                        if ($region->xy->y - 1 === $maxY) {
                            $surfaces[] = $surface;
                        }
                    }
                    $region->surface = Arr::random($surfaces);
                    $this->generatedRegions[$region->key()] = $region;
                    continue 2;
                }
            }
        }

        // 2) Generate surfaces by mountains
        $halfY = (int)round($this->worldRegionsY);
        $newSurfaces = [];
        foreach ($this->generatedRegions as $region) {
            if ($region->domain === Domain::Water) {
                continue;
            }
            if ($region->height >= 5) {
                $wetCoords = $this->validCoords(
                // Northern hemisphere moves left, Southern moves right
                    new Coordinate($region->xy->x + ($region->xy->y < $halfY ? -1 : 1), $region->xy->y)
                );
                $wetRegion = $this->generatedRegions[$wetCoords->key()];
                $newSurface = match (true) {
                    $wetRegion->height >= 5 => '',
                    $wetRegion->surface === Surface::Snow => Surface::Tundra,
                    in_array($wetRegion->surface, [Surface::Tundra, Surface::Desert]) => Surface::Plains,
                    in_array($wetRegion->surface, [Surface::Grass, Surface::Plains]) => Surface::Grass,
                    default => null,
                };
                if ($newSurface) {
                    $newSurfaces[$wetCoords->key()] = $newSurface;
                }

                $gridsLeft = 4;
                while ($gridsLeft) {
                    $dryCoords = $this->validCoords(
                    // Northern hemisphere moves right, Southern moves left
                        new Coordinate($region->xy->x + ($region->xy->y < $halfY ? 1 : -1), $region->xy->y)
                    );
                    $region = $this->generatedRegions[$dryCoords->key()];
                    $newSurface = match (true) {
                        $gridsLeft === 4,
                        in_array($region->surface, [Surface::Desert, Surface::Plains]) => Surface::Desert,
                        in_array($region->surface, [Surface::Snow, Surface::Tundra]) => Surface::Snow,
                        $region->surface === Surface::Grass => Surface::Plains,
                        default => null
                    };
                    if ($newSurface) {
                        $newSurfaces[$dryCoords->key()] = $newSurface;
                    }
                    $gridsLeft--;
                }
            }
        }
        foreach ($newSurfaces as $key => $surface) {
            $this->generatedRegions[$key]->surface = $surface;
        }

        return $this;
    }

    protected function generateFeatures(): self
    {
        // 1) Generate Features by latitude
        $twentieth = $this->worldRegionsY / 20;
        $featuresConfig = [
            // Top row is Snow
            [0, [Feature::Snowdrifts], [Feature::Snowdrifts]],

            // Next 2 rows are Tundra
            [2, [null, Feature::LightForest, Feature::PineForest], [null, Feature::PineForest, Feature::Shrubs]],

            // Grass
            [(int)round($twentieth * 5), [null, Feature::LushForest, Feature::PineForest], [null, Feature::PineForest]],

            // Plains
            [(int)round($twentieth * 7), [null, null, Feature::LightForest], [null, Feature::Shrubs]],

            // Desert
            [(int)round($twentieth * 9), [null, Feature::Dunes, Feature::Oasis], [null, Feature::Shrubs]],

            // Grass
            [(int)round($twentieth * 15), [Feature::Jungle], [null, Feature::LushForest, Feature::Jungle]],

            // Plains, leave 3 bottom rows for Tundra & Snow
            [$this->worldRegionsY - 4, [null, null, Feature::LightForest, Feature::PineForest], [null, Feature::Shrubs]],

            // Next two rows are Tundra
            [$this->worldRegionsY - 2, [null, Feature::LightForest, Feature::PineForest], [null, Feature::PineForest, Feature::Shrubs]],

            // Should be one row left as Snow
            [$this->worldRegionsY, [null, Feature::Snowdrifts], [null]],
        ];
        $regionsToGenerate = $this->generatedRegions;
        while ($regionsToGenerate) {
            /** @var Region $region */
            $region = Arr::random($regionsToGenerate);
            unset($regionsToGenerate[$region->key()]);
            if ($region->domain === Domain::Water && $region->height <= 0) {
                continue;
            }
            if ($region->height >= 5) {
                continue;
            }

            $features = [];
            $this->forEachNeighbor($region, function (Region $neighbor) use (&$features, $regionsToGenerate) {
                if (!$neighbor->feature) {
                    return;
                }
                $features[] = $neighbor->feature;
            });

            foreach ($featuresConfig as $key => $featureConfig) {
                [$maxY, $flatFeatures, $hillFeatures] = $featureConfig;
                if ($region->xy->y <= $maxY) {
                    $features = array_merge(
                        $features,
                        $region->height <= 0
                            ? $flatFeatures
                            : $hillFeatures
                    );

                    if ($prevFeatureConfig = $featuresConfig[$key - 1] ?? null) {
                        [$maxY, $flatFeatures, $hillFeatures] = $prevFeatureConfig;
                        if ($region->xy->y - 1 === $maxY) {
                            $features = array_merge(
                                $features,
                                $region->height <= 0
                                    ? $flatFeatures
                                    : $hillFeatures
                            );
                        }
                    }
                    $features = array_filter(
                        $features,
                        fn(?Feature $feature) => in_array($feature, Feature::casesForSurface($region->surface))
                    );
                    if (!$features) {
                        $features = Feature::casesForSurface($region->surface);
                    }
                    $region->feature = Arr::random($features);
                    $this->generatedRegions[$region->key()] = $region;
                    continue 2;
                }
            }
        }
        return $this;
    }

    protected function postProcess(): self
    {
        foreach ($this->generatedRegions as $region) {
            // 1st & last row MUST be water
            if (in_array($region->xy->y, [0, $this->worldRegionsY - 1]) && $region->domain !== Domain::Water) {
                $region->domain = Domain::Water;
                $region->height = -2;
                $region->surface = Surface::Coast;
                $region->feature = Feature::Shoals;
                $this->generatedRegions[$region->key()] = $region;
            }
        }
        return $this;
    }

    protected function validCoords(Coordinate $coords): ?Coordinate
    {
        $xy = clone $coords;
        if ($xy->y < 0 || $xy->y >= $this->worldRegionsY) {
            return null;
        }
        if ($xy->x < 0) {
            $xy->x = $this->worldRegionsX - 1;
            return $xy;
        }
        if ($xy->x >= $this->worldRegionsX) {
            $xy->x = 0;
            return $xy;
        }
        return $xy;
    }

    protected function forEachNeighbor(Region $region, callable $function, int $distance = 1): void
    {
        foreach (range($region->xy->x - $distance, $region->xy->x + $distance) as $x) {
            foreach (range($region->xy->y - $distance, $region->xy->y + $distance) as $y) {
                if ($x === $region->xy->x && $y === $region->xy->y) {
                    continue;
                }
                $xy = $this->validCoords(new Coordinate($x, $y));
                if (!$xy) {
                    continue;
                }

                $neighbor = $this->generatedRegions[$xy->key()] ?? $xy->key();
                $function($neighbor);
            }
        }
    }

    public function draw(): self
    {
        $counts = [
            'lake' => 0,
            'hill' => 0,
            'mountain' => 0,

            'deep' => 0,
            'island' => 0,
        ];
        foreach (Domain::cases() as $domain) {
            $counts[$domain->value] = 0;
        }
        foreach (Surface::cases() as $surface) {
            $counts[$surface->value] = 0;
        }
        foreach (Feature::cases() as $feature) {
            $counts[$feature->value] = 0;
        }

        // 1) Heightmap
        $heights = [];
        for ($y = -1; $y < $this->worldRegionsY; $y++) {
            if ($y < 0) {
                echo '  ';
            } else {
                echo str_pad($y, 2, ' ', STR_PAD_LEFT) . ' ';
            }

            for ($x = 0; $x < $this->worldRegionsX; $x++) {
                if ($y < 0) {
                    echo str_pad($x, 3, ' ', STR_PAD_LEFT);
                    continue;
                }
                $xy = new Coordinate($x, $y);
                $region = $this->generatedRegions[$xy->key()] ?? null;
                if (!$region) {
                    throw new \Exception("{$xy->key()} not generated");
                }
                echo match (true) {
                    $region->domain === Domain::Land && $region->height < 0 => '🟢',
                    $region->domain === Domain::Land && $region->height >= 5 => '🟫',
                    $region->domain === Domain::Land && $region->height > 0 => '🟧',
                    $region->domain === Domain::Land => '🟩',
                    $region->domain === Domain::Water && $region->height <= -3 => '🟪',
                    $region->domain === Domain::Water && $region->height > 0 => '🟨',
                    $region->domain === Domain::Water => '🟦',
                };
                $counts[$region->domain->value]++;
                if ($region->domain === Domain::Land && $region->height < 0) {
                    $counts['lake']++;
                }
                if ($region->domain === Domain::Land && $region->height >= 5) {
                    $counts['mountain']++;
                }
                if ($region->domain === Domain::Land && $region->height > 0) {
                    $counts['hill']++;
                }
                if ($region->domain === Domain::Water && $region->height <= -3) {
                    $counts['deep']++;
                }
                if ($region->domain === Domain::Water && $region->height > 0) {
                    $counts['island']++;
                }
                $heights[$region->height] = ($heights[$region->height] ?? 0) + 1;
            }
            echo PHP_EOL;
        }
        ksort($heights);

        $landPercent = round($counts[Domain::Land->value] / ($counts[Domain::Land->value] + $counts[Domain::Water->value]) * 100);
        $lakePercent = round($counts['lake'] / $counts[Domain::Land->value] * 100);
        $hillPercent = round($counts['hill'] / $counts[Domain::Land->value] * 100);
        $mountainPercent = round($counts['mountain'] / $counts[Domain::Land->value] * 100);
        $deepPercent = round($counts['deep'] / $counts[Domain::Water->value] * 100);
        $islandPercent = round($counts['island'] / $counts[Domain::Water->value] * 100);

        echo implode(
                PHP_EOL,
                [
                    "🟩 Land:      {$counts[Domain::Land->value]} ($landPercent%)",
                    "🟦 Water:     {$counts[Domain::Water->value]}",
                    "🟪 Ocean:     {$counts['deep']} ($deepPercent% of water)",
                    "🟨 Islands:   {$counts['island']} ($islandPercent% of water)",
                    "🟢 Lake:      {$counts['lake']} ($lakePercent% of land)",
                    "🟧 Hills:     {$counts['hill']} ($hillPercent% of land)",
                    "🟫 Mountains: {$counts['mountain']} ($mountainPercent% of land)",
                ]
            ) . PHP_EOL;
        echo implode(', ', array_merge($this->generatedContinents, $this->generatedOceans)) . PHP_EOL;

        // 2) Terrain & Feature Map
        echo PHP_EOL;
        for ($y = -1; $y < $this->worldRegionsY; $y++) {
            if ($y < 0) {
                echo '  ';
            } else {
                echo str_pad($y, 2, ' ', STR_PAD_LEFT) . ' ';
            }

            for ($x = 0; $x < $this->worldRegionsX; $x++) {
                if ($y < 0) {
                    echo str_pad($x, 4, ' ', STR_PAD_LEFT);
                    continue;
                }
                $xy = new Coordinate($x, $y);
                $region = $this->generatedRegions[$xy->key()];
                echo match ($region->feature) {
                    Feature::Snowdrifts => 'd',
                    Feature::Shrubs => 'S',
                    Feature::LightForest => 'l',
                    Feature::PineForest => 'P',
                    Feature::LushForest => 'L',
                    Feature::Jungle => 'J',
                    Feature::Dunes => 'D',
                    Feature::Oasis => 'O',
                    Feature::FloodPlain => 'f',
                    Feature::Shoals => 's',
                    Feature::Reef => 'R',
                    null => ' ',
                };
                echo match ($region->surface) {
                    Surface::Snow => '🟪',
                    Surface::Tundra => '🟫',
                    Surface::Grass => '🟩',
                    Surface::Plains => '🟧',
                    Surface::Desert => '🟨',
                    Surface::Ocean => '🟦',
                    Surface::Rock => '🟫',
                    Surface::Coast => '🟦',
                    Surface::River => '🟦',
                    Surface::Sea => '🟦',
                    null => ' ',
                };
                if ($region->surface) {
                    $counts[$region->surface->value]++;
                }
                if ($region->feature) {
                    $counts[$region->feature->value]++;
                }
            }
            echo PHP_EOL;
        }

        echo str_pad(Feature::Snowdrifts->name, 13, ' ') . ' s:  ';
        echo str_pad($counts[Feature::Snowdrifts->value], 4, ' ', STR_PAD_LEFT) . PHP_EOL;
        echo str_pad(Feature::Shrubs->name, 13, ' ') . ' S:  ';
        echo str_pad($counts[Feature::Shrubs->value], 4, ' ', STR_PAD_LEFT) . PHP_EOL;
        echo str_pad(Feature::LightForest->name, 13, ' ') . ' l:  ';
        echo str_pad($counts[Feature::LightForest->value], 4, ' ', STR_PAD_LEFT) . PHP_EOL;
        echo str_pad(Feature::PineForest->name, 13, ' ') . ' P:  ';
        echo str_pad($counts[Feature::PineForest->value], 4, ' ', STR_PAD_LEFT) . PHP_EOL;
        echo str_pad(Feature::LushForest->name, 13, ' ') . ' L:  ';
        echo str_pad($counts[Feature::LushForest->value], 4, ' ', STR_PAD_LEFT) . PHP_EOL;
        echo str_pad(Feature::Jungle->name, 13, ' ') . ' J:  ';
        echo str_pad($counts[Feature::Jungle->value], 4, ' ', STR_PAD_LEFT) . PHP_EOL;
        echo str_pad(Feature::Dunes->name, 13, ' ') . ' D:  ';
        echo str_pad($counts[Feature::Dunes->value], 4, ' ', STR_PAD_LEFT) . PHP_EOL;
        echo str_pad(Feature::Oasis->name, 13, ' ') . ' O:  ';
        echo str_pad($counts[Feature::Oasis->value], 4, ' ', STR_PAD_LEFT) . PHP_EOL;
        echo str_pad(Surface::Snow->name, 13, ' ') . '🟪: ';
        echo str_pad($counts[Surface::Snow->value], 4, ' ', STR_PAD_LEFT) . PHP_EOL;
        echo str_pad(Surface::Tundra->name, 13, ' ') . '🟫: ';
        echo str_pad($counts[Surface::Tundra->value], 4, ' ', STR_PAD_LEFT) . PHP_EOL;
        echo str_pad(Surface::Grass->name, 13, ' ') . '🟩: ';
        echo str_pad($counts[Surface::Grass->value], 4, ' ', STR_PAD_LEFT) . PHP_EOL;
        echo str_pad(Surface::Plains->name, 13, ' ') . '🟧: ';
        echo str_pad($counts[Surface::Plains->value], 4, ' ', STR_PAD_LEFT) . PHP_EOL;
        echo str_pad(Surface::Desert->name, 13, ' ') . '🟨: ';
        echo str_pad($counts[Surface::Desert->value], 4, ' ', STR_PAD_LEFT) . PHP_EOL;
        echo str_pad(Surface::Ocean->name, 13, ' ') . '🟦: ';
        echo str_pad($counts[Surface::Ocean->value], 4, ' ', STR_PAD_LEFT) . PHP_EOL;
        return $this;
    }

    public function void(): void
    {
    }
}
