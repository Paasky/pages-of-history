<?php

namespace App\Enums;

enum YieldType: string
{
    use GameConceptEnum;

    case Attack = 'Attack';
    case Bombard = 'Bombard';
    case Cargo = 'Cargo';
    case Cost = 'Cost';
    case Culture = 'Culture';
    case Damage = 'Damage';
    case Defense = 'Defense';
    case Faith = 'Faith';
    case Food = 'Food';
    case Gold = 'Gold';
    case Happiness = 'Happiness';
    case Health = 'Health';
    case Luxury = 'Luxury';
    case Moves = 'Moves';
    case ParachuteRange = 'ParachuteRange';
    case Production = 'Production';
    case Range = 'Range';
    case Science = 'Science';
    case Strength = 'Strength';
    case StrengthBack = 'StrengthBack';
    case StrengthFront = 'StrengthFront';
    case StrengthSide = 'StrengthSide';
    case Trade = 'Trade';
    case VisionRange = 'VisionRange';

    public function icon(): string
    {
        return match ($this) {
            self::Attack => 'fa-arrows-to-circle',
            self::Bombard => 'fa-crosshairs',
            self::Cargo => 'fa-box',
            self::Cost => 'fa-hammer',
            self::Culture => 'fa-masks-theater',
            self::Damage => 'fa-bomb',
            self::Defense => 'fa-shield-halved',
            self::Faith => 'fa-hands-praying',
            self::Food => 'fa-utensils',
            self::Gold => 'fa-coins',
            self::Happiness => 'fa-face-smile',
            self::Health => 'fa-heart',
            self::Luxury => 'fa-gem',
            self::Moves => 'fa-arrows-up-down-left-right',
            self::ParachuteRange => 'fa-parachute-box',
            self::Production => 'fa-industry',
            self::Range => 'fa-bullseye',
            self::Science => 'fa-flask',
            self::Strength => 'fa-hand-fist',
            self::StrengthBack => 'fa-arrows-up-to-line',
            self::StrengthFront => 'fa-arrow-up-from-bracket',
            self::StrengthSide => 'fa-arrows-left-right-to-line',
            self::Trade => 'fa-route',
            self::VisionRange => 'fa-eye',
        };
    }
}
