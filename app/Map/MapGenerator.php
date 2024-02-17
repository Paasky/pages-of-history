<?php

namespace App\Map;

use App\Coordinate;
use App\Enums\Domain;
use App\Enums\Feature;
use App\Enums\Surface;
use Illuminate\Support\Arr;

class MapGenerator
{
    public int $worldRegionsX = 90;
    public int $worldRegionsY = 30;
    public float $waterVsLandDistribution = 0.7;
    public float $initialOceansOrContinents = 7;
    public float $faultLinesMultiplier = 1.5;
    public float $faultLinesLength = 4;
    public float $faultLineDirections = 3;
    public float $maxOceanIslandChain = 2;
    public int $maxElevation = 10;
    public int $waterMinElevation = -5;
    public int $seaMaxElevation = -1;
    public int $oceanMaxElevation = -2;
    public int $landMinElevation = -2;
    public int $lakeMaxElevation = -1;
    public int $hillMaxElevation = 4;

    /** @var MapRegion[] */
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
            ->postProcess()

            // Height
            ->generateFaultLines()
            ->postProcess()
            ->smoothHeights()

            // Surfaces
            ->generateSurfaces()

            // Features
            ->generateFeatures()

            // Get rid of any randomness that's not allowed
            ->postProcess()
            ->draw();
        return $this;
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
                    $region->domain === Domain::Land && $region->elevation < 0 => '🟢',
                    $region->domain === Domain::Land && $region->elevation >= 5 => '🟫',
                    $region->domain === Domain::Land && $region->elevation > 0 => '🟧',
                    $region->domain === Domain::Land => '🟩',
                    $region->domain === Domain::Water && $region->elevation <= -3 => '🟪',
                    $region->domain === Domain::Water && $region->elevation > 0 => '🟨',
                    $region->domain === Domain::Water => '🟦',
                };
                $counts[$region->domain->value]++;
                if ($region->domain === Domain::Land && $region->elevation < 0) {
                    $counts['lake']++;
                }
                if ($region->domain === Domain::Land && $region->elevation >= 5) {
                    $counts['mountain']++;
                }
                if ($region->domain === Domain::Land && $region->elevation > 0) {
                    $counts['hill']++;
                }
                if ($region->domain === Domain::Water && $region->elevation <= -3) {
                    $counts['deep']++;
                }
                if ($region->domain === Domain::Water && $region->elevation > 0) {
                    $counts['island']++;
                }
                $heights[$region->elevation] = ($heights[$region->elevation] ?? 0) + 1;
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
        return $this;

        // 2) Terrain & Feature Map
        /** @noinspection PhpUnreachableStatementInspection */
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

    protected function postProcess(): self
    {
        foreach ($this->generatedRegions as $region) {
            // Coast without any water neighbors becomes a lake
            if ($region->surface === Surface::Coast) {
                $waterNeighbors = 0;
                $this->forEachNeighbor($region, function (MapRegion $neighbor) use (&$waterNeighbors) {
                    if ($neighbor->domain === Domain::Water) {
                        $waterNeighbors++;
                    }
                });
                if ($waterNeighbors < 3) {
                    $region->domain = Domain::Land;
                    $region->surface = Surface::Grass;
                    $region->feature = null;
                    $region->elevation = -2;
                    $this->generatedRegions[$region->key()] = $region;
                }
            }

            // Land without any land neighbors becomes sea
            if ($region->domain === Domain::Land) {
                $landNeighbors = 0;
                $this->forEachNeighbor($region, function (MapRegion $neighbor) use (&$landNeighbors) {
                    if ($neighbor->domain === Domain::Land) {
                        $landNeighbors++;
                    }
                });
                if (!$landNeighbors) {
                    $region->domain = Domain::Water;
                    $region->surface = Surface::Sea;
                    $region->feature = null;
                    $region->elevation = -2;
                    $this->generatedRegions[$region->key()] = $region;
                }
            }

            // Water with land neighbors must be Coast
            if ($region->domain === Domain::Water && $region->surface !== Surface::Coast) {
                $hasLandNeighbor = false;
                $this->forEachNeighbor($region, function (MapRegion $neighbor) use (&$hasLandNeighbor) {
                    if ($neighbor->domain === Domain::Land) {
                        $hasLandNeighbor = true;
                        return false;
                    }
                    return null;
                });
                if ($hasLandNeighbor) {
                    $region->surface = Surface::Coast;
                    $this->generatedRegions[$region->key()] = $region;
                }
            }

            // Ocean with Coast neighbors must be Sea
            if ($region->surface === Surface::Ocean) {
                $hasCoastNeighbor = false;
                $this->forEachNeighbor($region, function (MapRegion $neighbor) use (&$hasCoastNeighbor) {
                    if ($neighbor->surface === Surface::Coast) {
                        $hasCoastNeighbor = true;
                        return false;
                    }
                    return null;
                });
                if ($hasCoastNeighbor) {
                    $region->surface = Surface::Sea;
                    $this->generatedRegions[$region->key()] = $region;
                }
            }

            // 1st & last row MUST be water
            if (in_array($region->xy->y, [0, $this->worldRegionsY - 1]) && $region->domain !== Domain::Water) {
                $region->domain = Domain::Water;
                $region->elevation = 0;
                $region->surface = Surface::Coast;
                $region->feature = Feature::Shoals;
                $this->generatedRegions[$region->key()] = $region;
            }
        }
        return $this;
    }

    protected function forEachNeighbor(MapRegion $region, callable $function, int $distance = 1): void
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
                if ($function($neighbor) === false) {
                    return;
                }
            }
        }
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
            /** @var MapRegion $region */
            $region = Arr::random($regionsToGenerate);
            unset($regionsToGenerate[$region->key()]);
            if ($region->domain === Domain::Water && $region->elevation <= 0) {
                continue;
            }
            if ($region->elevation >= 5) {
                continue;
            }

            $features = [];
            $this->forEachNeighbor($region, function (MapRegion $neighbor) use (&$features, $regionsToGenerate) {
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
                        $region->elevation <= 0
                            ? $flatFeatures
                            : $hillFeatures
                    );

                    if ($prevFeatureConfig = $featuresConfig[$key - 1] ?? null) {
                        [$maxY, $flatFeatures, $hillFeatures] = $prevFeatureConfig;
                        if ($region->xy->y - 1 === $maxY) {
                            $features = array_merge(
                                $features,
                                $region->elevation <= 0
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

    protected function generateSurfaces(): self
    {
        // 1) Generate Climates by latitude
        $twentieth = $this->worldRegionsY / 20;
        $climates = [
            // Top row is Snow
            [0, Surface::Snow],
            // Next 2 rows are Tundra
            [2, Surface::Tundra],
            [(int)round($twentieth * 6), Surface::Grass],
            [(int)round($twentieth * 8), Surface::Plains],
            [(int)round($twentieth * 10), Surface::Desert],
            [(int)round($twentieth * 15), Surface::Grass],
            // Leave 3 bottom rows for Tundra & Snow
            [$this->worldRegionsY - 4, Surface::Plains],
            // Next two rows are Tundra
            [$this->worldRegionsY - 2, Surface::Tundra],
            // Should be one row left as Snow
            [$this->worldRegionsY, Surface::Snow],
        ];
        foreach ($this->generatedRegions as $region) {
            if ($region->domain === Domain::Water) {
                $region->surface = $region->elevation <= -3 ? Surface::Ocean : Surface::Sea;
                $this->generatedRegions[$region->key()] = $region;
                continue;
            }
            if ($region->elevation >= 5) {
                $region->surface = Surface::Rock;
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
            if ($region->elevation >= 5) {
                $wetCoords = $this->validCoords(
                // Northern hemisphere moves left, Southern moves right
                    new Coordinate($region->xy->x + ($region->xy->y < $halfY ? -1 : 1), $region->xy->y)
                );
                $wetRegion = $this->generatedRegions[$wetCoords->key()];
                $newSurface = match (true) {
                    $wetRegion->elevation >= 5 => '',
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

    protected function smoothHeights(): self
    {
        $newHeights = [];
        foreach ($this->generatedRegions as $key => $region) {
            $neighborHeights = [];
            $this->forEachNeighbor($region, function (MapRegion $neighbor) use (&$neighborHeights) {
                $neighborHeights[] = $neighbor->elevation;
            });
            $neighborAvg = (array_sum($neighborHeights) / count($neighborHeights));
            $newHeights[$key] = round(($region->elevation + $neighborAvg) / 2);
        }

        foreach ($this->generatedRegions as $key => $region) {
            $region->elevation = $newHeights[$key];
            $this->generatedRegions[$key] = $region;
        }

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
            /** @var MapRegion $region */
            $region = Arr::random($this->generatedRegions);
            $minDistanceFromPole = $this->worldRegionsY * 0.1;
            if ($region->xy->y < $minDistanceFromPole ||
                $region->xy->y >= $this->worldRegionsY - $minDistanceFromPole
            ) {
                continue;
            }

            $prevDirection = '';
            $directions = $this->faultLineDirections;
            $minDistanceFromPole = $this->worldRegionsY * 0.2;
            while ($directions) {
                $direction = collect(
                    match (true) {
                        $region->xy->y < $minDistanceFromPole => ['w', 'sw', 's', 'se', 'e'],
                        $region->xy->y >= $this->worldRegionsY - $minDistanceFromPole => ['w', 'nw', 'n', 'ne', 'e'],
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

    protected function buildFaultLine(MapRegion $region, string $direction): MapRegion
    {
        $oceanSteps = 0;
        for ($step = 1; $step <= $this->faultLinesLength; $step++) {
            if (!$region->elevation) {
                $region->elevation = $region->domain === Domain::Water ? 5 : 9;
            }
            if ($region->surface === Surface::Coast) {
                $region->domain = Domain::Land;
                $region->surface = null;
                $region->elevation = 5;
                $oceanSteps++;
            }
            if ($region->domain === Domain::Water && $region->elevation < 0 && rand(0, 1)) {
                $region->elevation = 5;
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

    protected function generateRegions(): self
    {
        /** @var MapRegion[] $regionsToGenerate */
        $regionsToGenerate = [];
        foreach (range(0, $this->worldRegionsX - 1) as $x) {
            foreach (range(0, $this->worldRegionsY - 1) as $y) {
                $region = new MapRegion(new Coordinate($x, $y));

                // Top & Bottom rows are always Deep Ocean
                if ($y === 0 || $y === $this->worldRegionsY - 1) {
                    $region->domain = Domain::Water;
                    $region->surface = Surface::Ocean;
                    $region->elevation = $this->waterMinElevation;
                    $this->generatedRegions[$region->key()] = $region;
                    continue;
                }

                $regionsToGenerate[$region->key()] = $region;
            }
        }
        $waterRegionsLeft = round(count($regionsToGenerate) * $this->waterVsLandDistribution);
        $landRegionsLeft = count($regionsToGenerate) - $waterRegionsLeft;
        $continentsLeft = round($this->initialOceansOrContinents);
        $oceansLeft = round($this->initialOceansOrContinents);

        while ($regionsToGenerate) {
            /** @var MapRegion $region */
            $region = Arr::random($regionsToGenerate);

            switch (true) {
                // Region is 2nd top or 2nd bottom row: 33% chance of land
                case in_array($region->xy->y, [1, $this->worldRegionsY - 2]):
                    $region->domain = rand(0, 2) ? Domain::Water : Domain::Land;
                    $region->elevation = $region->domain === Domain::Water
                        // Water level is random
                        ? Arr::random(range($this->waterMinElevation, $this->seaMaxElevation))
                        // Land level is random, but no random mountains
                        : Arr::random(range(0, $this->hillMaxElevation));
                    break;

                // Generating initial oceans
                case $oceansLeft:
                    // First 5 oceans are in the middle-ish of the map
                    if (count($this->generatedOceans) < 5) {
                        $sixthX = $this->worldRegionsX / 6;
                        $sixthY = $this->worldRegionsY / 6;

                        $oceanX = round(Arr::random([
                            $sixthX,
                            $sixthX * 2,
                            $sixthX * 3
                        ]));
                        $xDirection = Arr::random([1, -1]);

                        // Move the oceans diagonally left or right
                        $oceanCoords = $this->validCoords(match (count($this->generatedOceans)) {
                            0 => new Coordinate(
                                $oceanX,
                                round($sixthY)
                            ),
                            1 => new Coordinate(
                                $oceanX + ($sixthX * $xDirection),
                                round($sixthY * 3)
                            ),
                            2 => new Coordinate(
                                $oceanX + ($sixthX * 2 * $xDirection),
                                round($sixthY * 5)
                            ),

                            // Place an ocean on the polar opposites to prevent island-chaining in the poles
                            3 => new Coordinate(
                            // Fix chance of sixth * 6 going around the planet resulting in x under/overflow
                                $oceanX + ($sixthX * 2 * $xDirection),
                                round($sixthY)
                            ),
                            4 => new Coordinate(
                            // Fix chance of sixth * 6 going around the planet resulting in x under/overflow
                                $oceanX,
                                round($sixthY * 5),
                            ),
                        });

                        // Move the oceans diagonally left or right
                        $region = $regionsToGenerate[$oceanCoords->key()] ?? null;
                        if (!$region) {
                            throw new \Exception('index ' . count($this->generatedOceans) . " key {$oceanCoords->key()}");
                        }
                    }
                    $region->domain = Domain::Water;
                    $region->surface = Surface::Ocean;
                    $region->elevation = $this->waterMinElevation;
                    $this->generatedOceans[] = $region->group = "Ocean " . (count($this->generatedOceans) + 1);
                    $oceansLeft--;

                    // Generate neighbors
                    $this->forEachNeighbor(
                        $region,
                        function (MapRegion|string $neighbor)
                        use (&$regionsToGenerate, $region, &$waterRegionsLeft) {
                            // Already generated
                            if ($neighbor instanceof MapRegion) {
                                return;
                            }
                            $neighbor = $regionsToGenerate[$neighbor];

                            // If it's further away, only 50% chance of being Ocean
                            $distance = abs($region->xy->x - $neighbor->xy->x);
                            if ($distance > $this->worldRegionsY / 8 && rand(0, 1)) {
                                return;
                            }

                            // Oceans always spread to neighbors
                            $neighbor->domain = $region->domain;
                            $neighbor->surface = $region->surface;
                            $neighbor->elevation = $region->elevation;
                            $neighbor->group = $region->group;

                            $this->generatedRegions[$neighbor->key()] = $neighbor;
                            unset($regionsToGenerate[$neighbor->key()]);
                            $waterRegionsLeft--;
                        },
                        round($this->worldRegionsY / 7)
                    );
                    break;

                // Generating initial continents
                case $continentsLeft:
                    $region->domain = Domain::Land;
                    $region->elevation = $this->landMinElevation;
                    $this->generatedContinents[] = $region->group = "Continent " . (count($this->generatedContinents) + 1);
                    $continentsLeft--;

                    // Generate neighbors
                    $this->forEachNeighbor(
                        $region,
                        function (MapRegion|string $neighbor)
                        use (&$regionsToGenerate, $region, &$landRegionsLeft) {
                            // Already generated
                            if ($neighbor instanceof MapRegion) {
                                return;
                            }
                            $neighbor = $regionsToGenerate[$neighbor];

                            // If it's further away, 75-25% chance of being Land
                            $distance = abs($region->xy->x - $neighbor->xy->x);
                            if ($distance > $this->worldRegionsX / 30 && rand(0, 3)) { // 75% chance to skip
                                return;
                            }
                            if ($distance > $this->worldRegionsX / 35 && rand(0, 1)) { // 50% chance to skip
                                return;
                            }
                            if ($distance > $this->worldRegionsX / 40 && !rand(0, 3)) { // 25% chance to skip
                                return;
                            }

                            $neighbor->domain = Domain::Land;
                            $neighbor->group = $region->group;

                            // Lakes have a 1/4 chance to spread
                            if (!rand(0, 3)) {
                                $neighbor->elevation = -1;
                            }

                            $this->generatedRegions[$neighbor->key()] = $neighbor;
                            unset($regionsToGenerate[$neighbor->key()]);
                            $landRegionsLeft--;
                        },
                        round($this->worldRegionsX / 20)
                    );
                    break;

                // Default behaviour: Use regions left and neighbors as odds
                default:
                    $landNeighbors = 0;
                    $hasOceanNeighbor = false;
                    $possibleGroups = [];
                    $this->forEachNeighbor(
                        $region,
                        function (MapRegion|string $neighbor) use (&$landNeighbors, &$hasOceanNeighbor, &$possibleGroups) {
                            if ($neighbor instanceof MapRegion) {
                                if ($neighbor->domain === Domain::Land) {
                                    $landNeighbors++;
                                }
                                if ($neighbor->group) {
                                    $possibleGroups[$neighbor->domain->name][] = $neighbor->group;
                                }
                                if ($neighbor->domain == Domain::Water && $neighbor->elevation < 0) {
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
                    $region->elevation = match (true) {
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

    public function void(): void
    {
    }
}
