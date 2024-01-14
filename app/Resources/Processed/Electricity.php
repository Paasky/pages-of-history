<?php

namespace App\Resources\Processed;

use App\Enums\ImprovementCategory;
use App\Enums\ResourceCategory;
use App\Resources\ResourceType;
use App\Technologies\Bronze\BronzeWorking;
use App\Technologies\TechnologyType;

class Electricity extends ResourceType
{
    public function icon(): string
    {
        return 'fa-bolt';
    }

    public function category(): ResourceCategory
    {
        return ResourceCategory::Processed;
    }

    public function improvementCategory(): ?ImprovementCategory
    {
        return null;
    }

    public function technology(): ?TechnologyType
    {
        return \App\Technologies\Gilded\Electricity::get();
    }
}
