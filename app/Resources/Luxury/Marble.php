<?php

namespace App\Resources\Luxury;

use App\Enums\ImprovementCategory;
use App\Enums\ResourceCategory;
use App\Resources\ResourceType;

class Marble extends ResourceType
{
    public function icon(): string
    {
        return 'fa-boxes-stacked';
    }

    public function category(): ResourceCategory
    {
        return ResourceCategory::Luxury;
    }

    public function improvementCategory(): ImprovementCategory
    {
        return ImprovementCategory::Quarries;
    }
}
