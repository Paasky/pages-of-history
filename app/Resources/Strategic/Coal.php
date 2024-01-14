<?php

namespace App\Resources\Strategic;

use App\Enums\ImprovementCategory;
use App\Enums\ResourceCategory;
use App\Resources\ResourceType;
use App\Technologies\Enlightenment\Chemistry;
use App\Technologies\TechnologyType;

class Coal extends ResourceType
{
    public function icon(): string
    {
        return 'fa-mound';
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
        return Chemistry::get();
    }
}
