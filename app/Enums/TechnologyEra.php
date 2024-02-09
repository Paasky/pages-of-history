<?php

namespace App\Enums;

use App\GameConcept;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

enum TechnologyEra: string implements GameConcept
{
    use GameConceptEnum;

    public const BASE_COST = 10;
    public const BASE_STRENGTH = 4;
    public const BASE_ARMOR_COST = 5;
    public const BASE_ARMOR_STRENGTH = 1;

    case Neolithic = 'Neolithic';
    case Copper = 'Copper';
    case Bronze = 'Bronze';
    case Iron = 'Iron';
    case Classical = 'Classical';
    case Medieval = 'Medieval';
    case HighMedieval = 'HighMedieval';
    case Renaissance = 'Renaissance';
    case Enlightenment = 'Enlightenment';
    case Industrial = 'Industrial';
    case Gilded = 'Gilded';
    case Modern = 'Modern';
    case Atomic = 'Atomic';
    case Digital = 'Digital';
    case Information = 'Information';
    case Nano = 'Nano';

    public function baseArmorStrength(): int
    {
        return match ($this) {
            self::Neolithic => self::BASE_ARMOR_STRENGTH,
            self::Copper => 2,
            self::Bronze => 3,
            self::Iron => 4,
            self::Classical => 5,
            self::Medieval => 6,
            self::HighMedieval => 7,
            self::Renaissance => 8,
            self::Enlightenment => 9,
            self::Industrial => 10,
            self::Gilded => 11,
            self::Modern => 12,
            self::Atomic => 13,
            self::Digital => 15,
            self::Information => 18,
            self::Nano => 20,
        };
    }

    public function baseCost(): int
    {
        return match ($this) {
            self::Neolithic => self::BASE_COST,
            self::Copper => 12,
            self::Bronze => 14,
            self::Iron => 17,
            self::Classical => 20,
            self::Medieval => 24,
            self::HighMedieval => 30,
            self::Renaissance => 39,
            self::Enlightenment => 53,
            self::Industrial => 74,
            self::Gilded => 107,
            self::Modern => 161,
            self::Atomic => 250,
            self::Digital => 400,
            self::Information => 660,
            self::Nano => 1122,
        };
    }

    public function baseStrength(): int
    {
        return match ($this) {
            self::Neolithic => self::BASE_STRENGTH,
            self::Copper => 5,
            self::Bronze => 7,
            self::Iron => 9,
            self::Classical => 12,
            self::Medieval => 14,
            self::HighMedieval => 16,
            self::Renaissance => 21,
            self::Enlightenment => 24,
            self::Industrial => 28,
            self::Gilded => 36,
            self::Modern => 41,
            self::Atomic => 47,
            self::Digital => 61,
            self::Information => 70,
            self::Nano => 80,
        };
    }

    public function order(): int
    {
        return match ($this) {
            self::Neolithic => 1,
            self::Copper => 2,
            self::Bronze => 3,
            self::Iron => 4,
            self::Classical => 5,
            self::Medieval => 6,
            self::HighMedieval => 7,
            self::Renaissance => 8,
            self::Enlightenment => 9,
            self::Industrial => 10,
            self::Gilded => 11,
            self::Modern => 12,
            self::Atomic => 13,
            self::Digital => 14,
            self::Information => 15,
            self::Nano => 16,
        };
    }

    public function name(): string
    {
        return \Str::title(str_replace('-', ' ', $this->slug()));
    }

    public function slug(): string
    {
        return \Str::kebab($this->name);
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function technologies(): Collection
    {
        return TechnologyType::all()->filter(fn(TechnologyType $type) => $type->era() === $this);
    }

    public function icon(): string
    {
        return YieldType::Science->icon();
    }

    /** @return Collection<int, GameConcept> */
    public function items(): Collection
    {
        return TechnologyType::all()->filter(
            fn(TechnologyType $type) => $type->era() === $this
        );
    }

    public function typeSlug(): string
    {
        return 'technology';
    }
}
