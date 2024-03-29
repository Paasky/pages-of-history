<?php

namespace App\Buildings\Happiness;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Resources\ResourceType;
use App\Resources\Strategic\Gas;
use App\Technologies\Industrial\CoalGasification;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class StreetLighting extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Happiness;
    }

    /**
     * @return Collection<int, ResourceType>
     */
    public function resources(): Collection
    {
        return collect([Gas::get()]);
    }

    public function technology(): ?TechnologyType
    {
        return CoalGasification::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return TradeUnion::get();
    }
}
