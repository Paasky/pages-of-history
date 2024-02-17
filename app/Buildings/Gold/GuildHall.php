<?php

namespace App\Buildings\Gold;

use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Technologies\HighMedieval\Guilds;
use App\Technologies\TechnologyType;

class GuildHall extends BuildingType
{
    public function category(): BuildingCategory
    {
        return BuildingCategory::Gold;
    }

    public function technology(): ?TechnologyType
    {
        return Guilds::get();
    }

    public function upgradesTo(): ?BuildingType
    {
        return Bank::get();
    }
}
