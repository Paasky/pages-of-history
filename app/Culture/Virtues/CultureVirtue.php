<?php

namespace App\Culture\Virtues;

use App\Enums\YieldType;
use App\Yields\YieldModifier;

abstract class CultureVirtue
{
    abstract public function yieldType(): YieldType;

    abstract public function yieldModifier(): YieldModifier;
}
