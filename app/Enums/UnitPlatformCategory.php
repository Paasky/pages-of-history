<?php

namespace App\Enums;

use App\UnitArmor\UnitArmorType;
use App\GameConcept;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Support\Collection;

enum UnitPlatformCategory: string implements GameConcept
{
    use GameConceptEnum;
    use PohEnum;

    case Foot = 'Foot';
    case Mounted = 'Mounted';
    case Vehicle = 'Vehicle';
    case Air = 'Air';
    case Naval = 'Naval';
    case Space = 'Space';

    /** @return Collection<int, GameConcept> */
    public function allows(): Collection
    {
        return $this->armorCategories()->merge($this->equipmentCategories());
    }

    /** @return Collection<int, UnitArmorCategory> */
    public function armorCategories(): Collection
    {
        $armorCategories = collect();
        foreach (UnitArmorCategory::cases() as $armorCategory) {
            foreach ($armorCategory->platformCategories() as $platformCategory) {
                if ($platformCategory === $this) {
                    $armorCategories->push($armorCategory);
                }
            }
        }
        return $armorCategories;
    }

    /** @return Collection<int, UnitEquipmentCategory> */
    public function equipmentCategories(): Collection
    {
        $equipmentCategories = collect();
        foreach (UnitEquipmentCategory::cases() as $equipmentCategory) {
            foreach ($equipmentCategory->platformCategories() as $platformCategory) {
                if ($platformCategory === $this) {
                    $equipmentCategories->push($equipmentCategory);
                }
            }
        }
        return $equipmentCategories;
    }

    public function icon(): string
    {
        return match ($this) {
            self::Foot => 'fa-shoe-prints',
            self::Mounted => 'fa-horse',
            self::Vehicle => 'fa-car',
            self::Air => 'fa-plane',
            self::Naval => 'fa-ship',
            self::Space => 'fa-satellite',
        };
    }

    /** @return Collection<int, GameConcept> */
    public function items(): Collection
    {
        return UnitPlatformType::all()->filter(
            fn(UnitPlatformType $type) => $type->category() === $this
        );
    }

    public function typeSlug(): string
    {
        return 'platform';
    }
}
