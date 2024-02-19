<?php

namespace App\UnitEquipment;

use App\AbstractType;
use App\Buildings\BuildingType;
use App\Enums\BuildingCategory;
use App\Enums\ImprovementCategory;
use App\Enums\TechnologyEra;
use App\Enums\UnitEquipmentCategory;
use App\Enums\UnitEquipmentClass;
use App\Enums\UnitPlatformCategory;
use App\Enums\UnitType;
use App\Enums\YieldType;
use App\GameConcept;
use App\Resources\ResourceType;
use App\UnitPlatforms\Person;
use App\UnitPlatforms\UnitPlatformType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use App\Yields\YieldModifiersTowards;
use Illuminate\Support\Collection;

abstract class UnitEquipmentType extends AbstractType
{
    public int $weight = 2;

    public function building(): BuildingType|BuildingCategory|null
    {
        return null;
    }

    public function canHaveArmor(): bool
    {
        return !$this->category()->class()->is(UnitEquipmentClass::NonCombat)
            && !$this->category()->is(
                UnitEquipmentCategory::Ranged,
                UnitEquipmentCategory::Skirmish,
                UnitEquipmentCategory::SkirmishFirearm,
                UnitEquipmentCategory::NavalAssault,
                UnitEquipmentCategory::MissileBay,
                UnitEquipmentCategory::Torpedo,
                UnitEquipmentCategory::AntiAir,
            );
    }

    abstract public function category(): UnitEquipmentCategory;

    public function icon(): string
    {
        return $this->category()->icon();
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

    /** @return Collection<int, GameConcept> */
    public function requires(): Collection
    {
        return collect([$this->building(), $this->technology(), ...$this->resources(), ...$this->platforms()])->filter();
    }

    /**
     * @return Collection<int, ResourceType>
     */
    public function resources(): Collection
    {
        return collect();
    }

    public function unitType(): UnitType
    {
        return $this->category()->unitType();
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

    /** @return Collection<int, YieldModifier|YieldModifiersFor> */
    public function yieldModifiers(): Collection
    {
        $modifiers = match ($this->category()) {
            UnitEquipmentCategory::Melee => collect([
                new YieldModifiersTowards(
                    new YieldModifier($this, YieldType::Strength, percent: 10),
                    Person::get()
                )
            ]),
            UnitEquipmentCategory::Firearm => collect([
                new YieldModifiersTowards(
                    new YieldModifier($this, YieldType::Strength, percent: 20),
                    [Person::get(), UnitPlatformCategory::Mounted]
                )
            ]),
            UnitEquipmentCategory::Spear => collect([
                new YieldModifier($this, YieldType::StrengthFront, percent: 20),
                new YieldModifier($this, YieldType::StrengthSide, percent: -20),
                new YieldModifier($this, YieldType::StrengthBack, percent: -50),
                new YieldModifiersTowards(
                    new YieldModifier($this, YieldType::Strength, percent: 25),
                    UnitPlatformCategory::Mounted
                )
            ]),
            UnitEquipmentCategory::AntiTank, UnitEquipmentCategory::AntiTankGun => collect([
                new YieldModifiersTowards(
                    new YieldModifier($this, YieldType::Strength, percent: 33),
                    UnitPlatformCategory::Vehicle
                )
            ]),
            UnitEquipmentCategory::Skirmish => collect([
                new YieldModifier($this, YieldType::Range, 1),
                new YieldModifier($this, YieldType::Defense, percent: -25),
                new YieldModifiersTowards(
                    new YieldModifier($this, YieldType::Attack, percent: -50),
                    [ImprovementCategory::Cities, ImprovementCategory::Forts]
                ),
            ]),
            UnitEquipmentCategory::SkirmishFirearm => collect([
                new YieldModifier($this, YieldType::Range, 1),
                new YieldModifier($this, YieldType::Defense, percent: 25),
            ]),
            UnitEquipmentCategory::Ranged => collect([
                new YieldModifier($this, YieldType::Range, 2),
                new YieldModifier($this, YieldType::Defense, percent: -50),
                new YieldModifiersTowards(
                    new YieldModifier($this, YieldType::Attack, percent: -50),
                    [ImprovementCategory::Cities, ImprovementCategory::Forts]
                ),
            ]),
            UnitEquipmentCategory::Siege => collect([
                new YieldModifier($this, YieldType::Range, 2),
                new YieldModifiersTowards(
                    new YieldModifier($this, YieldType::Attack, percent: 25),
                    [ImprovementCategory::Cities, ImprovementCategory::Forts]
                ),
            ]),
            UnitEquipmentCategory::Cannon => collect([
                new YieldModifier($this, YieldType::Range, 2),
                new YieldModifiersTowards(
                    new YieldModifier($this, YieldType::Attack, percent: 33),
                    [ImprovementCategory::Cities, ImprovementCategory::Forts]
                ),
            ]),
            UnitEquipmentCategory::Artillery => collect([
                new YieldModifier($this, YieldType::Range, 3),
                new YieldModifiersTowards(
                    new YieldModifier($this, YieldType::Attack, percent: 50),
                    [ImprovementCategory::Cities, ImprovementCategory::Forts]
                ),
            ]),
            UnitEquipmentCategory::RocketArtillery => collect([
                new YieldModifier($this, YieldType::Range, 3),
                new YieldModifiersTowards(
                    new YieldModifier($this, YieldType::Attack, percent: 50),
                    [ImprovementCategory::Cities, ImprovementCategory::Forts]
                ),
                new YieldModifiersTowards(
                    new YieldModifier($this, YieldType::Strength, percent: 25),
                    [Person::get(), UnitPlatformCategory::Mounted]
                ),
            ]),
            UnitEquipmentCategory::MissileBay => collect([
                new YieldModifier($this, YieldType::Strength, percent: -25),
                new YieldModifiersFor(
                    new YieldModifier($this, YieldType::Capacity, 3),
                    [UnitPlatformCategory::Missile]
                ),
            ]),
            UnitEquipmentCategory::FlightDeck => collect([
                new YieldModifier($this, YieldType::Strength, percent: -25),
                // Capacity & visibility range are set per each FlightDeck
            ]),
            UnitEquipmentCategory::EnergyWeapon => collect([
                new YieldModifier($this, YieldType::Range, 4),
            ]),
            UnitEquipmentCategory::AntiAir => collect([
                new YieldModifier($this, YieldType::Range, 2),
                new YieldModifier($this, YieldType::Defense, percent: -50),
                new YieldModifiersTowards(
                    new YieldModifier($this, YieldType::Strength, percent: 50),
                    UnitPlatformCategory::Air
                ),
            ]),
            UnitEquipmentCategory::AirGun => collect([
                new YieldModifiersTowards(
                    new YieldModifier($this, YieldType::Strength, percent: 25),
                    UnitPlatformCategory::Air
                ),
            ]),
            UnitEquipmentCategory::AirBomb => collect([
                new YieldModifier($this, YieldType::Range, percent: 20),
                new YieldModifier($this, YieldType::Defense, percent: -25),
                new YieldModifiersTowards(
                    new YieldModifier($this, YieldType::Strength, percent: 25),
                    [UnitPlatformCategory::Vehicle, UnitPlatformCategory::Naval]
                ),
            ]),
            UnitEquipmentCategory::NavalAssault => collect([
                new YieldModifiersTowards(
                    new YieldModifier($this, YieldType::Attack, percent: 25),
                    UnitPlatformCategory::Naval
                )
            ]),
            UnitEquipmentCategory::Torpedo => collect([
                new YieldModifier($this, YieldType::Defense, percent: -25),
                new YieldModifiersTowards(
                    new YieldModifier($this, YieldType::Attack, percent: 50),
                    UnitPlatformCategory::Naval
                )
            ]),
//            UnitEquipmentCategory::MassDestruction => ,
//            UnitEquipmentCategory::Espionage => ,
//            UnitEquipmentCategory::Diplomacy => ,
//            UnitEquipmentCategory::Trade => ,
//            UnitEquipmentCategory::Expansion => ,
//            UnitEquipmentCategory::Exploring => ,
//            UnitEquipmentCategory::Building => ,
            default => collect(),
        };

        $modifiers->add(new YieldModifier(
                $this,
                YieldType::Cost,
                $this->technology()?->era()->baseCost() ?: TechnologyEra::BASE_COST)
        );

        if ($this->category()->class() !== UnitEquipmentClass::NonCombat) {
            $modifiers->add(new YieldModifier(
                    $this,
                    YieldType::Strength,
                    $this->technology()?->era()->baseStrength() ?: TechnologyEra::BASE_STRENGTH)
            );
        }

        return $modifiers;
    }
}
