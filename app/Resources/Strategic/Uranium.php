<?php

namespace App\Resources\Strategic;

use App\Enums\ImprovementCategory;
use App\Enums\ResourceCategory;
use App\Resources\ResourceType;
use App\Technologies\Modern\AtomicTheory;
use App\Technologies\TechnologyType;

class Uranium extends ResourceType
{
    public function icon(): string
    {
        return 'fa-circle-radiation';
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
        return AtomicTheory::get();
    }
}
