<?php

namespace App\Resources\Strategic;

use App\Enums\ImprovementCategory;
use App\Enums\ResourceCategory;
use App\Resources\ResourceType;
use App\Technologies\Renaissance\Gunpowder;
use App\Technologies\TechnologyType;

class Saltpeter extends ResourceType
{
    public function icon(): string
    {
        return 'fa-explosion';
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
        return Gunpowder::get();
    }
}
