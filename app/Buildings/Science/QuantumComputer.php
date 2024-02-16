<?php

namespace App\Buildings\Science;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Information\QuantumComputing;
use App\Technologies\TechnologyType;

class QuantumComputer extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Science;
    }

    public function technology(): ?TechnologyType
    {
        return QuantumComputing::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return NeuralLink::get();
    }
}
