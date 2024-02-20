<?php

namespace App\Enums;

use App\GameConcept;
use App\Models\Building;
use App\Models\Citizen;
use App\Models\City;
use App\Models\Hex;
use App\Models\Unit;
use App\Models\UnitDesign;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

enum YieldType: string implements GameConcept
{
    use GameConceptEnum;

    case Agility = 'Agility';
    case Attack = 'Attack';
    case Bombard = 'Bombard';
    case Capacity = 'Capacity';
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

    public static function casesFor(GameConcept|Model $for): Collection
    {
        return collect(self::cases())
            ->filter(fn(YieldType $type) => $type->isFor($for))
            ->values();
    }

    /**
     * @param ...$models Model
     * @return bool
     */
    public function isFor(...$models): bool
    {
        if (in_array($this, [
            self::Culture,
            self::Faith,
            self::Food,
            self::Gold,
            self::Happiness,
            self::Health,
            self::Luxury,
            self::Production,
            self::Science,
            self::Trade,
        ])) {
            foreach ($models as $model) {
                if ($model instanceof Building ||
                    $model instanceof Citizen ||
                    $model instanceof City ||
                    $model instanceof Hex
                ) {
                    return true;
                }
            }
        }

        if (in_array($this, [
            self::Bombard,
            self::Defense,
            self::Range,
            self::Strength,
            self::VisionRange,
        ])) {
            foreach ($models as $model) {
                if ($model instanceof City ||
                    ($model instanceof Hex && $model->improvement?->is(...ImprovementCategory::Forts->items())) ||
                    $model instanceof Unit ||
                    $model instanceof UnitDesign
                ) {
                    return true;
                }
            }
        }

        if (in_array($this, [
            self::Agility,
            self::Attack,
            self::Capacity,
            self::Cost,
            self::Damage,
            self::Moves,
            self::ParachuteRange,
            self::StrengthBack,
            self::StrengthFront,
            self::StrengthSide,
        ])) {
            foreach ($models as $model) {
                if ($model instanceof Unit ||
                    $model instanceof UnitDesign
                ) {
                    return true;
                }
            }
        }

        return false;
    }

    public function icon(): string
    {
        return match ($this) {
            self::Agility => 'fa-plane-circle-check',
            self::Attack => 'fa-arrows-to-circle',
            self::Bombard => 'fa-crosshairs',
            self::Capacity => 'fa-warehouse',
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

    /** @return Collection<int, GameConcept> */
    public function items(): Collection
    {
        return collect();
    }

    public function typeSlug(): string
    {
        return 'yield';
    }
}
