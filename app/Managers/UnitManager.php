<?php

namespace App\Managers;

use App\Enums\Armor;
use App\Enums\UnitCategory;
use App\Enums\UnitType;
use App\Enums\Weapon;
use App\Exceptions\PohException;
use App\Models\Hex;
use App\Models\Unit;
use Illuminate\Support\Collection;

class UnitManager
{
    public const BASE_BATTLE_DAMAGE = 25;
    public const BASE_COST = 75;
    public const DAMAGE_VARIETY = 2;
    public const MOVE_COST_PER_ELEVATION_DIFF = 0.5;
    public const STRENGTH_DIFF_MULTIPLIER = 50;

    public function __construct(protected readonly Unit $unit)
    {
    }

    public static function for(Unit $unit): static
    {
        return new static($unit);
    }

    public static function getCost(UnitType $type, Weapon $weapon = null, Armor $armor = null): int
    {
        $baseCost = (
            $weapon?->cost() + $armor?->cost()
        ) ?: static::BASE_COST;

        return round($baseCost * $type->costMultiplier());
    }

    public function attack(Hex $to): static
    {
        $this->canAttack($to, true);

        $defender = null;
        foreach ($to->units as $unit) {
            if ($unit->type->category()->is(UnitCategory::Combat)) {
                $defender = $unit;
                break;
            }
            if ($unit->type->category()->is(UnitCategory::Support)) {
                $defender = $unit;
                continue;
            }
            if (!$defender) {
                $defender = $unit;
            }
        }

        if (!$this->unit->weapon?->range()) {
            $this->unit->health = max(
                $this->unit->health - $this->getAttackerDamage($defender, false),
                0
            );

            $this->unit->health === 0
                ? $this->unit->delete()
                : $this->unit->save();
        }

        $defender->health = max(
            $defender->health - $this->getDefenderDamage($defender, false),
            0
        );

        $defender->health === 0
            ? $defender->delete()
            : $defender->save();

        return $this;
    }

    public function getAttackerDamage(Unit $defender, bool $isPrediction): int
    {
        $damage = static::BASE_BATTLE_DAMAGE + (
                ($defender->getStrengthAttribute($this->unit) / $this->unit->getStrengthAttribute($defender) - 1)
                * static::STRENGTH_DIFF_MULTIPLIER
            );

        if (!$isPrediction) {
            $damage += random_int(static::DAMAGE_VARIETY * -1, static::DAMAGE_VARIETY);
        }

        return min(max(round($damage), 0), 100);
    }

    public function getDefenderDamage(Unit $defender, bool $isPrediction): int
    {
        $damage = static::BASE_BATTLE_DAMAGE + (
                ($this->unit->getStrengthAttribute($defender) / $defender->getStrengthAttribute($this->unit) - 1)
                * static::STRENGTH_DIFF_MULTIPLIER
            );

        if (!$isPrediction) {
            $damage += random_int(static::DAMAGE_VARIETY * -1, static::DAMAGE_VARIETY);
        }

        return min(max(round($damage), 0), 100);
    }

    /**
     * @return Collection<int, Hex>
     */
    public function getAdjacentMovableHexes(): Collection
    {
        return $this->unit->hex->adjacent_hexes->filter(
            fn(Hex $hex) => $this->canMoveToAdjacent($hex)
        );
    }

    public function canMoveToAdjacent(Hex $to, bool $orFail = false): bool
    {
        // Unit & Hex must have moves remaining
        if ($this->unit->moves_remaining <= 0) {
            if ($orFail) {
                throw new PohException("{$this->unit->name} has no moves remaining", $this->unit);
            }
            return false;
        }

        // Unit & Hex must have the same domain
        if (!$to->surface->domain()->is($this->unit->type->domain())) {
            if ($orFail) {
                throw new PohException("{$this->unit->name} is not the same domain as {$to->name}", $this->unit);
            }
            return false;
        }

        // Elevation difference
        $elevationDifference = abs($to->elevation - $this->unit->hex->elevation);
        if ($elevationDifference > $this->unit->type->maxElevationPerMove()) {
            if ($orFail) {
                throw new PohException("Elevation difference is too big for {$this->unit->name} moving to {$to->name}", $this->unit);
            }
            return false;
        }

        // Now make sure any units on it doesn't prevent a move
        foreach ($to->units as $unit) {
            if ($unit->type->category()->is(UnitCategory::Combat) && $unit->player_id !== $this->unit->player_id) {
                if ($orFail) {
                    throw new PohException("{$to->name} is occupied by {$unit->player->name}", $this->unit);
                }
                return false;
            }
            if ($unit->type->is($this->unit->type)) {
                if ($orFail) {
                    throw new PohException("{$to->name} already has a {$unit->type->name} unit", $this->unit);
                }
                return false;
            }
        }

        return true;
    }

    public function move(Hex $to): static
    {
        $this->isAdjacent($to, true);
        $this->canMoveToAdjacent($to, true);
        $this->unit->hex()->associate($to);
        $movesRemaining = $this->unit->moves_remaining - $this->getMoveCost($to);
        $this->unit->moves_remaining = max(0, $movesRemaining);
        return $this;
    }

    public function isAdjacent(Hex $to, bool $orFail = false): bool
    {
        // Unit & Hex must be on the same map
        if ($to->map_id !== $this->unit->map_id) {
            if ($orFail) {
                throw new PohException("{$this->unit->name} is not on the same map as {$to->name}", $this->unit);
            }
            return false;
        }

        // Unit & Hex must be adjacent
        if (!$this->unit->hex->adjacent_hexes->contains($to)) {
            if ($orFail) {
                throw new PohException("{$this->unit->name} is not adjacent to {$to->name}", $this->unit);
            }
            return false;
        }

        return true;
    }

    public function getMoveCost(Hex $to): float
    {
        $elevationDifference = abs($to->elevation - $this->unit->hex->elevation);
        return $to->surface->moveCost()
            + $to->feature?->moveCost()
            + ($elevationDifference * static::MOVE_COST_PER_ELEVATION_DIFF);
    }
}
