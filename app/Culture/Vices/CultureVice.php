<?php

namespace App\Culture\Vices;

use App\Enums\YieldType;
use App\Yields\YieldModifier;

abstract class CultureVice
{
    abstract public function yieldType(): YieldType;

    abstract public function yieldModifier(): YieldModifier;
}
