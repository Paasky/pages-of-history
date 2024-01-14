<?php

namespace App\Yields;

use App\Enums\BuildingCategory;
use App\Enums\Domain;
use App\Enums\Feature;
use App\Enums\ImprovementCategory;
use App\Enums\Surface;
use App\Enums\UnitCategory;
use Illuminate\Support\Collection;

class YieldModifiersFor
{
    /**
     * @param Collection<int, YieldModifier> $modifiers
     * @param Domain|Feature|BuildingCategory|ImprovementCategory|Surface|UnitCategory $for
     */
    public function __construct(
        public Collection                                                               $modifiers,
        public Domain|Feature|BuildingCategory|ImprovementCategory|Surface|UnitCategory $for,
    )
    {
    }
}
