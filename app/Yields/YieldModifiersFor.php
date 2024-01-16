<?php

namespace App\Yields;

use App\GameConcept;
use Illuminate\Support\Collection;

class YieldModifiersFor
{
    /**
     * @param Collection<int, YieldModifier> $modifiers
     * @param GameConcept $for
     */
    public function __construct(public Collection $modifiers, public GameConcept $for)
    {
    }
}
