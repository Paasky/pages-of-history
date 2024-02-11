<?php

namespace App\Map;

use App\Coordinate;
use App\Enums\Domain;
use App\Enums\Feature;
use App\Enums\Surface;

class Region
{
    public function __construct(
        public Coordinate $xy,
        public ?Domain    $domain = null,
        public int        $height = 0,
        public ?Surface   $surface = null,
        public ?Feature   $feature = null,
        public ?string    $group = null,
    )
    {
    }

    public function key(): string
    {
        return $this->xy->key();
    }
}
