<?php

namespace App\Buildings\Happiness;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Resources\Processed\Electricity;
use App\Technologies\Modern\ArtDeco;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

class Metro extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Happiness;
    }

    public function resources(): Collection
    {
        return collect([Electricity::get()]);
    }

    public function upgradesTo(): ?BuildingType
    {
        return ShoppingMall::get();
    }

    public function technology(): ?TechnologyType
    {
        return ArtDeco::get();
    }
}
