<?php

namespace App\Resources\Strategic;

use App\Enums\ImprovementCategory;
use App\Enums\ResourceCategory;
use App\Resources\ResourceType;
use App\Technologies\Bronze\AnimalHusbandry;
use App\Technologies\TechnologyType;

class Horses extends ResourceType
{
    public function icon(): string
    {
        return 'fa-horse';
    }

    public function category(): ResourceCategory
    {
        return ResourceCategory::Strategic;
    }

    public function improvementCategory(): ImprovementCategory
    {
        return ImprovementCategory::Pastures;
    }

    public function technology(): ?TechnologyType
    {
        return AnimalHusbandry::get();
    }
}
