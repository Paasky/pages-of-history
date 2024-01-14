<?php

namespace App\Enums;

enum BuildingCategory: string
{
    case AirTrade = 'Air Trade';
    case AirTraining = 'Air Training';
    case Culture = 'Culture';
    case Defense = 'Defense';
    case Food = 'Food';
    case Gold = 'Gold';
    case Happiness = 'Happiness';
    case Health = 'Health';
    case LandTrade = 'Land Trade';
    case LandTraining = 'Land Training';
    case Production = 'Production';
    case Faith = 'Religion';
    case SeaTrade = 'Sea Trade';
    case SeaTraining = 'Sea Training';
    case Science = 'Science';

    public function icon(): string
    {
        return match ($this) {
            self::AirTrade => 'fa-plane-departure',
            self::AirTraining => 'fa-jet-fighter-up',
            self::Culture => YieldType::Culture->icon(),
            self::Defense => YieldType::Defense->icon(),
            self::Faith => YieldType::Faith->icon(),
            self::Food => YieldType::Food->icon(),
            self::Gold => YieldType::Gold->icon(),
            self::Happiness => YieldType::Happiness->icon(),
            self::Health => YieldType::Health->icon(),
            self::LandTrade => 'fa-cart-shopping',
            self::LandTraining => 'fa-person-military-rifle',
            self::Production => YieldType::Production->icon(),
            self::SeaTrade => 'fa-anchor',
            self::SeaTraining => 'fa-ship',
            self::Science => YieldType::Science->icon(),
        };
    }

    public function name(): string
    {
        return $this->name;
    }

    public function shortName(): string
    {
        return $this->name;
    }

    public function typeSlug(): string
    {
        return 'building';
    }
}
