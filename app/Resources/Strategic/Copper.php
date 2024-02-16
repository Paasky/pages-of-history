<?php

namespace App\Resources\Strategic;

use App\Enums\ImprovementCategory;
use App\Enums\ResourceCategory;
use App\Resources\ResourceType;
use App\Technologies\Copper\CopperWorking;
use App\Technologies\TechnologyType;

class Copper extends ResourceType
{
    public function icon(): string
    {
        return 'fa-c';
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
        return CopperWorking::get();
    }
}
