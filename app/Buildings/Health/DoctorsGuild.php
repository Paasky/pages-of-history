<?php

namespace App\Buildings\Health;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\HighMedieval\Optics;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

class DoctorsGuild extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Health;
    }

    public function technology(): ?TechnologyType
    {
        return Optics::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Hospital::get();
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
