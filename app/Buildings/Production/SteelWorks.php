<?php

namespace App\Buildings\Production;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Resources\ResourceType;
use App\Resources\Strategic\Coal;
use App\Resources\Strategic\Iron;
use App\Technologies\Gilded\SteelMilling;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class SteelWorks extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Production;
    }

    /**
     * @return Collection<int, ResourceType>
     */
    public function resources(): Collection
    {
        return collect([Iron::get(), Coal::get()]);
    }

    public function technology(): ?TechnologyType
    {
        return SteelMilling::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return AssemblyLine::get();
    }
}
