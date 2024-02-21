<?php

namespace App\Map;

use App\Coordinate;
use App\Enums\Domain;
use App\Enums\Feature;
use App\Enums\Surface;
use App\Models\Hex;
use Illuminate\Support\Collection;

class MapRegion
{
    /** @var Collection<Hex> */
    public Collection $hexes;
    public function __construct(
        public Coordinate $xy,
        public ?Domain    $domain = null,
        public int $elevation = 0,
        public ?Surface   $surface = null,
        public ?Feature   $feature = null,
        public ?string    $group = null,
        ?Collection $hexes = null,
    )
    {
        $this->hexes = $hexes ?: collect();
    }

    public function key(): string
    {
        return $this->xy->key();
    }
}
