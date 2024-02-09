<?php

namespace App\UnitArmor;

use App\AbstractType;
use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Enums\TechnologyEra;
use App\Enums\UnitArmorCategory;
use App\Enums\YieldType;
use App\GameConcept;
use App\Resources\ResourceType;
use App\UnitPlatforms\UnitPlatformType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

abstract class UnitArmorType extends AbstractType
{
    public int $weight = 1;

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

    /** @return Collection<int, YieldModifier|YieldModifiersFor> */
    public function yieldModifiers(): Collection
    {
        return collect([
            new YieldModifier(
                YieldType::Cost,
                percent: 25
            ),
            new YieldModifier(
                YieldType::Strength,
                $this->technology()?->era()->baseArmorStrength() ?: TechnologyEra::BASE_ARMOR_STRENGTH
            ),
        ]);
    }
}
