<?php

namespace App\Buildings\Trade;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Resources\Processed\Steel;
use App\Resources\ResourceType;
use App\Technologies\Industrial\Railroad;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class CentralStation extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::LandTrade;
    }

    /**
     * @return Collection<int, ResourceType>
     */
    public function resources(): Collection
    {
        return collect([Steel::get()]);
    }

    public function upgradesTo(): ?BuildingType
    {
        return Motorway::get();
    }

    public function technology(): ?TechnologyType
    {
        return Railroad::get();
    }
}
