<?php

namespace App\Map;

use App\Coordinate;
use App\Enums\Domain;
use Illuminate\Support\Arr;

class MapGenerator
{
    public int $worldRegionsX = 36;
    public int $worldRegionsY = 18;
    public float $waterVsLandDistribution = 0.66;
    public float $initialOceansOrContinentsMultiplier = 0.8;
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
            // Surfaces
            // Features
        ;
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
                $region->height = 10;
            }
            if ($region->domain === Domain::Water && $region->height < 0 && rand(0, 1)) {
                $region->height = 10;
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
        $continentsLeft = round($this->worldRegionsY / 2 * $this->initialOceansOrContinentsMultiplier);
        $oceansLeft = round($this->worldRegionsY / 2 * $this->initialOceansOrContinentsMultiplier);

        while ($regionsToGenerate) {
            /** @var Region $region */
            $region = Arr::random($regionsToGenerate);

            switch (true) {
                // Region is top or bottom row: must be water
                case in_array($region->xy->y, [0, $this->worldRegionsY - 1]):
                    $region->domain = Domain::Water;
                    $region->height = -10;
                    break;

                // Region is 2nd top or 2nd bottom row or no land regions left: 33-67 chance
                case in_array($region->xy->y, [1, $this->worldRegionsY - 2]):
                    $region->domain = rand(0, 2) ? Domain::Water : Domain::Land;
                    $region->height = $region->domain === Domain::Water
                        ? (rand(0, 1) ? 0 : -10)
                        : 0;
                    break;

                // Generating initial continents
                // Generate 1st 4 continents, then 1st 4 oceans, then the rest
                case $continentsLeft && (count($this->generatedContinents) < 4 || count($this->generatedOceans) >= 4):
                    // First 4 continents are in four corners of the map
                    if (count($this->generatedContinents) < 4) {
                        $thirdX = round($this->worldRegionsX / 3);
                        $fifthY = round($this->worldRegionsY / 4);
                        $newRegion = match (count($this->generatedContinents)) {
                            0 => $regionsToGenerate[(new Coordinate($thirdX, $fifthY))->key()] ?? null,
                            1 => $regionsToGenerate[(new Coordinate($thirdX, $fifthY * 3))->key()] ?? null,
                            2 => $regionsToGenerate[(new Coordinate($thirdX * 2, $fifthY))->key()] ?? null,
                            3 => $regionsToGenerate[(new Coordinate($thirdX * 2, $fifthY * 3))->key()] ?? null,
                        };
                        if ($newRegion) {
                            $region = $newRegion;
                        }
                    }
                    $region->domain = Domain::Land;
                    $region->height = -10;
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
                                $neighbor->height = -10;
                            }

                            $this->generatedRegions[$neighbor->key()] = $neighbor;
                            unset($regionsToGenerate[$neighbor->key()]);
                            $landRegionsLeft--;
                        }
                    );
                    break;

                // Generating initial oceans
                case $oceansLeft:
                    // First 3 oceans are in the middle of the map
                    if (count($this->generatedOceans) < 4) {
                        $halfX = round($this->worldRegionsX / 2);
                        $fifthY = round($this->worldRegionsY / 5);
                        $newRegion = match (count($this->generatedOceans)) {
                            0 => $regionsToGenerate[(new Coordinate($halfX, $fifthY))->key()] ?? null,
                            1 => $regionsToGenerate[(new Coordinate($halfX, $fifthY * 2))->key()] ?? null,
                            2 => $regionsToGenerate[(new Coordinate($halfX, $fifthY * 3))->key()] ?? null,
                            3 => $regionsToGenerate[(new Coordinate($halfX, $fifthY * 4))->key()] ?? null,
                        };
                        if ($newRegion) {
                            $region = $newRegion;
                        }
                    }
                    $region->domain = Domain::Water;
                    $region->height = -10;
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
                            $neighbor->height = -10;

                            $this->generatedRegions[$neighbor->key()] = $neighbor;
                            unset($regionsToGenerate[$neighbor->key()]);
                            $waterRegionsLeft--;
                        }
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
                        $hasOceanNeighbor => rand(0, $landNeighbors) ? 0 : -10,
                        default => $landNeighbors ? 0 : -10
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

    public function draw(): void
    {
        $counts = [
            Domain::Land->value => 0,
            Domain::Water->value => 0,
            'lake' => 0,
            'deep' => 0,
            'island' => 0,
            'mountain' => 0,
        ];
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
                    $region->domain === Domain::Water && $region->height < 0 => '🟪',
                    $region->domain === Domain::Land && $region->height > 0 => '🟫',
                    $region->domain === Domain::Water && $region->height > 0 => '🟨',
                    $region->domain === Domain::Land => '🟩',
                    $region->domain === Domain::Water => '🟦',
                };
                $counts[$region->domain->value]++;
                if ($region->domain === Domain::Land && $region->height < 0) {
                    $counts['lake']++;
                }
                if ($region->domain === Domain::Land && $region->height > 0) {
                    $counts['mountain']++;
                }
                if ($region->domain === Domain::Water && $region->height < 0) {
                    $counts['deep']++;
                }
                if ($region->domain === Domain::Water && $region->height > 0) {
                    $counts['island']++;
                }
            }
            echo PHP_EOL;
        }

        $landPercent = round($counts[Domain::Land->value] / ($counts[Domain::Land->value] + $counts[Domain::Water->value]) * 100);
        $lakePercent = round($counts['lake'] / $counts[Domain::Land->value] * 100);
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
                    "🟫 Mountains: {$counts['mountain']} ($mountainPercent% of land)",
                ]
            ) . PHP_EOL;
        echo implode(', ', array_merge($this->generatedContinents, $this->generatedOceans));
    }
}
