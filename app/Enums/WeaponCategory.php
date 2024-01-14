<?php

namespace App\Enums;

enum WeaponCategory: string
{
    use PohEnum;

    case CloseCombat = 'CloseCombat';
    case Ranged = 'Ranged';
    case Aerial = 'Aerial';
    case Bomb = 'Bomb';
    case MassDestruction = 'MassDestruction';
    case Support = 'Support';
}
