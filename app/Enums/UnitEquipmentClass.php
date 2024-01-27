<?php

namespace App\Enums;

use App\GameConcept;
use App\UnitEquipment\UnitEquipmentType;
use Illuminate\Support\Collection;

enum UnitEquipmentClass: string implements GameConcept
{
    use GameConceptEnum;
    use PohEnum;

    case NonCombat = 'NonCombat';
    case CloseCombat = 'CloseCombat';
    case Ranged = 'Ranged';
    case Aerial = 'Aerial';
    case Bomb = 'Bomb';
    case MassDestruction = 'MassDestruction';
    case Support = 'Support';

    public function icon(): string
    {
        return match ($this) {
            self::NonCombat => 'fa-house',
            self::CloseCombat => YieldType::Attack->icon(),
            self::Ranged => YieldType::Range->icon(),
            self::Aerial => 'fa-jet-fighter',
            self::Bomb => 'fa-plane',
            self::MassDestruction => 'fa-circle-radiation',
            self::Support => YieldType::Defense->icon(),
        };
    }

    /** @return Collection<int, GameConcept> */
    public function items(): Collection
    {
        $items = collect();
        foreach (UnitEquipmentCategory::cases() as $category) {
            if ($category->class() === $this) {
                $items->push($category);
            }
        }
        foreach (UnitEquipmentType::all() as $type) {
            if ($type->category()->class() === $this) {
                $items->push($type);
            }
        }
        return $items;
    }

    public function typeSlug(): string
    {
        return 'equipment';
    }
}
