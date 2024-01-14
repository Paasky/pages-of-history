<?php

namespace App\Enums;

enum YieldType: string
{
    case Attack = 'Attack';
    case Bombard = 'Bombard';
    case Culture = 'Culture';
    case Damage = 'Damage';
    case Defense = 'Defense';
    case Faith = 'Faith';
    case Food = 'Food';
    case Gold = 'Gold';
    case Happiness = 'Happiness';
    case Health = 'Health';
    case Luxury = 'Luxury';
    case Movement = 'Movement';
    case Production = 'Production';
    case Range = 'Range';
    case Science = 'Science';
    case Trade = 'Trade';

    public function icon(): string
    {
        return match ($this) {
            self::Attack => 'fa-arrows-to-circle',
            self::Bombard => 'fa-crosshairs',
            self::Culture => 'fa-masks-theater',
            self::Damage => 'fa-bomb',
            self::Defense => 'fa-shield-halved',
            self::Faith => 'fa-hands-praying',
            self::Food => 'fa-utensils',
            self::Gold => 'fa-coins',
            self::Happiness => 'fa-face-smile',
            self::Health => 'fa-heart',
            self::Luxury => 'fa-gem',
            self::Production => 'fa-industry',
            self::Movement => 'fa-arrows-up-down-left-right',
            self::Range => 'fa-bullseye',
            self::Science => 'fa-flask',
            self::Trade => 'fa-route',
        };
    }
}
