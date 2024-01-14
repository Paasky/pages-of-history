<?php

namespace App\Managers;

use App\Enums\YieldType;
use App\Models\Citizen;
use App\Models\City;
use App\Models\Player;

class YieldManager
{
    public function getYield(YieldType $yieldType, Player $player, City $city = null, Citizen $citizen = null): float
    {

    }
}
