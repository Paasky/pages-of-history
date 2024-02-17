<?php

namespace App\Buildings\Trade;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Resources\ResourceType;
use App\Resources\Strategic\Oil;
use App\Technologies\Atomic\Macroeconomics;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Motorway extends BuildingType
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
        return collect([Oil::get()]);
    }

    public function technology(): ?TechnologyType
    {
        return Macroeconomics::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return null;
    }
}
