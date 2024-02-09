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
     * @param YieldModifier|YieldModifier[]|Collection<int, YieldModifier> $modifiers
     * @param GameConcept|GameConcept[]|Collection<int, GameConcept> $for
     */
    public function __construct(YieldModifier|array|Collection $modifiers, GameConcept|array|Collection $for)
    {
        $this->modifiers = collect();
        if ($modifiers instanceof YieldModifier) {
            $modifiers = [$modifiers];
        }
        foreach ($modifiers as $modifiersItem) {
            if (!$modifiersItem instanceof YieldModifier) {
                throw new \Exception('$modifiers is not a YieldModifier!');
            }
            $this->modifiers->push($modifiersItem);
        }

        $this->for = collect();
        if ($for instanceof GameConcept) {
            $for = [$for];
        }
        foreach ($for as $forItem) {
            if (!$forItem instanceof GameConcept) {
                throw new \Exception('$for is not a GameConcept!');
            }
            $this->for->push($forItem);
        }
    }
}
