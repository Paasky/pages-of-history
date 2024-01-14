<?php

namespace App\Resources\Strategic;

use App\Enums\ImprovementCategory;
use App\Enums\ResourceCategory;
use App\Resources\ResourceType;
use App\Technologies\Industrial\Nitroglycerin;
use App\Technologies\TechnologyType;

class Oil extends ResourceType
{
    public function icon(): string
    {
        return 'fa-droplet';
    }

    public function category(): ResourceCategory
    {
        return ResourceCategory::Strategic;
    }

    public function improvementCategory(): ImprovementCategory
    {
        return ImprovementCategory::Mines;
    }

    public function technology(): ?TechnologyType
    {
        return Nitroglycerin::get();
    }
}
