<?php

namespace App\Enums;

use App\GameConcept;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Support\Collection;

enum UnitCapability: string implements GameConcept
{
    use GameConceptEnum;

    case CanTravelOnSea = 'CanTravelOnSea';
    case CanTravelOnOcean = 'CanTravelOnOcean';
    case CanTravelOnIce = 'CanTravelOnIce';
    case CanTravelOnDunes = 'CanTravelOnDunes';
    case CanTravelOnJungle = 'CanTravelOnJungle';
    case CanTravelOnMountains = 'CanTravelOnMountains';
    case InvisibleBeforeAttack = 'InvisibleBeforeAttack';
    case AttackCostsZeroMoves = 'AttackCostsZeroMoves';
    case CanMoveAfterAttack = 'CanMoveAfterAttack';
    case CanRebaseAnywhere = 'CanRebaseAnywhere';
    case CanBombAnywhere = 'CanBombAnywhere';
    case CanEnterBorders = 'CanEnterBorders';

    public function icon(): string
    {
        return 'fa-gears';
    }

    /** @return Collection<int, GameConcept> */
    public function items(): Collection
    {
        $items = collect();
        foreach (UnitPlatformType::all() as $platform) {
            foreach ($platform->modifiers() as $modifier) {
                if ($modifier === $this) {
                    $items->push($platform);
                }
            }
        }
        foreach (UnitPlatformType::all() as $platform) {
            foreach ($platform->modifiers() as $modifier) {
                if ($modifier === $this) {
                    foreach ($platform->items() as $platformItem) {
                        $items->push($platformItem);
                    }
                }
            }
        }
        return $items;
    }

    public function typeSlug(): string
    {
        return 'capability';
    }
}
