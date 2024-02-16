<?php

namespace App\Buildings\Science;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Nano\NeuralNetworks;
use App\Technologies\TechnologyType;

class NeuralLink extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Science;
    }

    public function technology(): ?TechnologyType
    {
        return NeuralNetworks::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return null;
    }
}
