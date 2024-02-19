<?php

namespace App\Buildings\Culture;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Gilded\HauteCouture;
use App\Technologies\TechnologyType;

class ArtGallery extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Culture;
    }

    public function technology(): ?TechnologyType
    {
        return HauteCouture::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return JazzClub::get();
    }
}
