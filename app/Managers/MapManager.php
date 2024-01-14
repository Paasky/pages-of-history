<?php

namespace App\Managers;

use App\Coordinate;
use App\Enums\Feature;
use App\Enums\Surface;
use App\Enums\Domain;
use App\Models\Hex;
use App\Models\Map;

class MapManager
{
    public const MAX_ELEVATION = 12;

    public function __construct(protected readonly Map $map)
    {
    }

    public static function for(Map $map): static
    {
        return new static($map);
    }

    public function generateHexes(): void
    {
        $hexData = [];
        for ($x = 0; $x < $this->map->width; $x++) {
            for ($y = 0; $y < $this->map->height; $y++) {
                /** @var Surface $surface */
                $surface = \Arr::random(Surface::cases());
                $hexData[] = [
                    'map_id' => $this->map->id,
                    'x' => $x,
                    'y' => $y,
                    'surface' => $surface,
                    'elevation' => $surface->domain()->is(Domain::Water)
                        ? 0
                        : random_int(1, static::MAX_ELEVATION),
                    'feature' => \Arr::random(Feature::casesForSurface($surface)),
                ];
            }
        }
        Hex::insert($hexData);
    }

    /**
     * @param Coordinate $coord
     * @param Coordinate $maxCoord
     * @param int $distance
     * @return Coordinate[]
     */
    public static function adjacentCoordinates(Coordinate $coord, Coordinate $maxCoord, int $distance = 1): array
    {
        [$x, $y] = [$coord->x, $coord->y];

        // Don't bother checking hexes outside the map
        if ($x < 0 || $y < 0) {
            return [];
        }

        $xIsEven = $x % 2 === 0;

        /** @var Coordinate[] $hexes */
        if ($xIsEven) {
            $hexes = [
                new Coordinate($x - 1, $y),
                new Coordinate($x, $y + 1),
                new Coordinate($x + 1, $y),
                new Coordinate($x + 1, $y - 1),
                new Coordinate($x, $y - 1),
                new Coordinate($x - 1, $y - 1),
            ];
        } else {
            $hexes = [
                new Coordinate($x - 1, $y + 1),
                new Coordinate($x, $y + 1),
                new Coordinate($x + 1, $y + 1),
                new Coordinate($x + 1, $y),
                new Coordinate($x, $y - 1),
                new Coordinate($x - 1, $y),
            ];
        }

        // Use x-y as the key to prevent duplicates
        /** @var Coordinate[] $trackedHexes */
        $trackedHexes = [];
        foreach ($hexes as $hex) {
            // Only track hexes on the map
            if (
                $hex->x > 0 &&
                $hex->x <= $maxCoord->x &&
                $hex->y > 0 &&
                $hex->y <= $maxCoord->y
            ) {
                $trackedHexes["$hex->x-$hex->y"] = $hex;
            }
        }

        // Keep looking for hexes until the distance becomes 1
        while ($distance > 1) {
            $distance--;
            foreach ($hexes as $hex) {
                $trackedHexes = array_merge(
                    $trackedHexes,
                    static::adjacentCoordinates($hex, $maxCoord, $distance)
                );
            }
        }

        // Ignore orig hex
        unset($trackedHexes["$x-$y"]);

        return $trackedHexes;
    }
}
