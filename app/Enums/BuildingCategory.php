<?php

namespace App\Enums;

use App\Buildings\BuildingType;
use App\GameConcept;
use Illuminate\Support\Collection;

enum BuildingCategory: string implements GameConcept
{
    use GameConceptEnum;

    case AirTrade = 'AirTrade';
    case AirTraining = 'AirTraining';
    case Culture = 'Culture';
    case Defense = 'Defense';
    case Food = 'Food';
    case Gold = 'Gold';
    case Government = 'Government';
    case Happiness = 'Happiness';
    case Health = 'Health';
    case LandTrade = 'LandTrade';
    case LandTraining = 'LandTraining';
    case Production = 'Production';
    case Faith = 'Religion';
    case SeaTrade = 'SeaTrade';
    case SeaTraining = 'SeaTraining';
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
            self::Government => 'fa-building-columns',
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

    /**
     * @return Collection<int, GameConcept>
     */
    public function items(): Collection
    {
        return BuildingType::all()->filter(
            fn(BuildingType $type) => $type->category() === $this
        );
    }

    public function typeSlug(): string
    {
        return 'building';
    }
}
