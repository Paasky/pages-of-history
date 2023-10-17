<?php

namespace App;

use Illuminate\Support\Arr;

class Coordinate
{
    public int $x;
    public int $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public static function fromArray(array $coords): static
    {
        $x = $coords['x'] ?? $coords['lng'] ?? $coords['long'] ?? $coords['longitude'] ?? Arr::first($coords);
        $y = $coords['y'] ?? $coords['lat'] ?? $coords['latitude'] ?? Arr::last($coords);

        return new static($x, $y);
    }

    public function toXYArray(): array
    {
        return ['x' => $this->x, 'y' => $this->y];
    }
}