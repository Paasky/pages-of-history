<?php

namespace App\UnitEquipment;

use App\AbstractType;
use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Enums\UnitEquipmentCategory;
use App\Enums\UnitEquipmentClass;
use App\GameConcept;
use App\Resources\ResourceType;
use App\UnitPlatforms\UnitPlatformType;
use Illuminate\Support\Collection;

abstract class UnitEquipmentType extends AbstractType
{
    public int $weight = 2;

    public function canHaveArmor(): bool
    {
        return !$this->category()->class()->is(UnitEquipmentClass::NonCombat);
    }

    public function icon(): string
    {
        return $this->category()->icon();
    }

    abstract public function category(): UnitEquipmentCategory;

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
            foreach ($platform->equipment() as $equipment) {
                if ($equipment === $this) {
                    $platforms->push($platform);
                }
            }
        }
        return $platforms;
    }

    /**
     * @return Collection<int, UnitEquipmentType>
     */
    public static function all(): Collection
    {
        return static::instances(
            app_path('UnitEquipment'),
            [UnitEquipmentType::class]
        );
    }

    /** @return Collection<int, UnitEquipmentType> */
    public function upgradesFrom(): Collection
    {
        return $this::all()->filter(fn(UnitEquipmentType $equipmentType) => $equipmentType->upgradesTo() === $this);
    }
}
