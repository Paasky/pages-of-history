<?php

namespace App\Managers;

use App\Exceptions\PohException;
use App\Models\Hex;
use App\Models\Unit;

class UnitManager
{
    public function __construct(protected readonly ?Unit $unit = null)
    {
    }

    public static function for(Unit $unit): static
    {
        return new static($unit);
    }

    public function move(Hex $to): static
    {
        $this->validateMove($to);
        $this->unit->hex()->associate($to);
        return $this;
    }

    protected function validateMove(Hex $hex): void
    {
        if ($hex->map_id !== $this->unit->map_id) {
            throw new PohException(
                "$hex->name is not on the same map as {$this->unit->name}",
                $hex
            );
        }

        foreach ($this->unit->hex->adjacent_hexes as $adjacentHex) {
            if (!$adjacentHex->id === $hex->id) {
                continue;
            }

            // Found the hex we're trying to move to

            // Now make sure any units on it don't prevent a move
            foreach ($adjacentHex->units as $unit) {
                if ($unit->player_id !== $this->unit->player_id) {
                    throw new PohException(
                        "$adjacentHex->name is occupied by {$unit->player->name}",
                        $hex
                    );
                }
                if ($unit->type->is($this->unit->type)) {
                    throw new PohException(
                        "$adjacentHex->name already has a {$unit->type->name} unit",
                        $hex
                    );
                }
            }

            // All checks pass, return without any exceptions
            return;
        }

        throw new PohException(
            "$hex->name is not adjacent to {$this->unit->name}"
        );
    }
}
