<?php

namespace App\Buildings\Gold;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\Iron\Bureaucracy;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class Governor extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Gold;
    }

    public function technology(): ?TechnologyType
    {
        return Bureaucracy::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return GuildHall::get();
    }

    /**
     * @return Collection<int, YieldModifiersFor>
     */
    public function yieldModifiers(): Collection
    {
        return collect([

        ]);
    }
}
