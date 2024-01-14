<?php

namespace App\Resources\Bonus;

use App\Enums\ImprovementCategory;
use App\Enums\ResourceCategory;
use App\Resources\ResourceType;

class Wheat extends ResourceType
{
    public function icon(): string
    {
        return 'fa-wheat-awn';
    }

    public function category(): ResourceCategory
    {
        return ResourceCategory::Bonus;
    }

    public function improvementCategory(): ImprovementCategory
    {
        return ImprovementCategory::Farms;
    }
}
