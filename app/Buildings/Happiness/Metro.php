<?php

namespace App\Buildings\Happiness;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Modern\ArtDeco;
use App\Technologies\TechnologyType;

class Metro extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Happiness;
    }

    public function technology(): ?TechnologyType
    {
        return ArtDeco::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return ShoppingMall::get();
    }
}
