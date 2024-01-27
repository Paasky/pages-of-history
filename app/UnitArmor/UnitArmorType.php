<?php

namespace App\UnitArmor;

use App\AbstractType;
use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Enums\UnitArmorCategory;
use App\GameConcept;
use App\UnitPlatforms\UnitPlatformType;
use App\Resources\ResourceType;
use Illuminate\Support\Collection;

abstract class UnitArmorType extends AbstractType
{
    public function icon(): string
    {
        return $this->category()->icon();
    }

    abstract public function category(): UnitArmorCategory;

    /** @return Collection<int, GameConcept> */
    public function requires(): Collection
    {
        return collect([$this->building(), $this->technology(), ...$this->resources(), ...$this->platforms()])->filter();
    }

    public function building(): BuildingType|BuildingCategory|null
    {
        return null;
    }

    /**
     * @return Collection<int, ResourceType>
     */
    public function resources(): Collection
    {
        return collect();
    }

    /** @return Collection<int, UnitPlatformType> */
    public function platforms(): Collection
    {
        $platforms = collect();
        foreach (UnitPlatformType::all() as $platform) {
            foreach ($platform->armors() as $armor) {
                if ($armor === $this) {
                    $platforms->push($platform);
                }
            }
        }
        return $platforms;
    }

    /**
     * @return Collection<int, UnitArmorType>
     */
    public static function all(): Collection
    {
        return static::instances(
            app_path('UnitArmor'),
            [UnitArmorType::class]
        );
    }

    /** @return Collection<int, UnitArmorType> */
    public function upgradesFrom(): Collection
    {
        return $this::all()->filter(fn(UnitArmorType $armorType) => $armorType->upgradesTo() === $this);
    }
}
