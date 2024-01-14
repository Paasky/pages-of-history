<?php

namespace App\Culture\Traits;

use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

abstract class CultureTrait
{
    /**
     * @return Collection<int, YieldModifiersFor>
     */
    abstract public function yieldModifierFors(): Collection;
}
