<?php

namespace App\Buildings\Trade;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Enums\ImprovementCategory;
use App\Enums\YieldType;
use App\Technologies\Digital\Globalization;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class ContainerDock extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::SeaTrade;
    }

    public function technology(): ?TechnologyType
    {
        return Globalization::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return null;
    }

    /**
     * @return Collection<int, YieldModifiersFor>
     */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifiersFor(
                collect([
                    new YieldModifier(YieldType::Food, 1),
                    new YieldModifier(YieldType::Gold, 1),
                    new YieldModifier(YieldType::Production, 1),
                ]),
                ImprovementCategory::Fisheries
            ),
        ]);
    }
}
