<?php

namespace App\Yields;

use App\GameConcept;
use Illuminate\Support\Collection;

class YieldModifiersFor
{
    /** @var Collection<int, YieldModifier> */
    public Collection $modifiers;
    /** @var Collection<int, GameConcept> */
    public Collection $for;

    /**
     * @param Collection<int, YieldModifier> $modifiers
     * @param GameConcept|GameConcept[]|Collection $for
     */
    public function __construct(Collection $modifiers, GameConcept|array|Collection $for)
    {
        $this->modifiers = $modifiers;
        if ($for instanceof GameConcept) {
            $for = [$for];
        }
        $this->for = collect();
        foreach ($for as $forItem) {
            if (!$forItem instanceof GameConcept) {
                throw new \Exception('$for is not a game concept!');
            }
            $this->for->push($forItem);
        }
    }
}
