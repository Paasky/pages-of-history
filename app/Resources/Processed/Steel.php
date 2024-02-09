<?php

namespace App\Resources\Processed;

use App\Enums\ImprovementCategory;
use App\Enums\ResourceCategory;
use App\Resources\ResourceType;
use App\Technologies\TechnologyType;

class Steel extends ResourceType
{
    public function icon(): string
    {
        return 'fa-shield';
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
        return \App\Technologies\HighMedieval\Steel::get();
    }
}
