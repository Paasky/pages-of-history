<?php

namespace App\UnitPlatforms;

use App\AbstractType;
use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Enums\UnitCapability;
use App\Enums\UnitPlatformCategory;
use App\GameConcept;
use App\Resources\ResourceType;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\UnitEquipmentType;
use Illuminate\Support\Collection;

abstract class UnitPlatformType extends AbstractType
{
    public int $equipmentSlots = 0;
    public int $armorSlots = 0;
    public int $maxWeight = 0;
    public int $moves = 2;
    public int $range = 0;
    public int $maneuvering = 0;

    /** @return Collection<int, UnitArmorType> */
    abstract public function armors(): Collection;

    abstract public function category(): UnitPlatformCategory;

    /** @return Collection<int, GameConcept> */
    public function requires(): Collection
    {
        return collect([$this->building(), $this->technology(), ...$this->resources()])->filter();
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

    /** @return Collection<int, UnitCapability> */
    public function modifiers(): Collection
    {
        return collect();
    }

    /** @return Collection<int, UnitPlatformType> */
    public function upgradesFrom(): Collection
    {
        return $this::all()->filter(fn(UnitPlatformType $platformType) => $platformType->upgradesTo() === $this);
    }

    /**
     * @return Collection<int, UnitPlatformType>
     */
    public static function all(): Collection
    {
        return static::instances(
            app_path('UnitPlatforms'),
            [UnitPlatformType::class]
        );
    }

    /** @return Collection<int, UnitEquipmentType> */
    abstract public function equipment(): Collection;
}
