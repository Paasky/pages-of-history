<?php

namespace App\Buildings\Culture;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Modern\ArtDeco;
use App\Technologies\TechnologyType;

class JazzClub extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Culture;
    }

    public function technology(): ?TechnologyType
    {
        return ArtDeco::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return TvTower::get();
    }
}
