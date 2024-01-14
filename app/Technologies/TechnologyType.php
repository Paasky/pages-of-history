<?php

namespace App\Technologies;

use App\AbstractType;
use App\Buildings\BuildingType;
use App\Coordinate;
use App\Enums\TechnologyEra;
use App\Enums\YieldType;
use App\Improvements\ImprovementType;
use App\Resources\ResourceType;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

abstract class TechnologyType extends AbstractType
{
    /** @var Collection<int, BuildingType>[] */
    protected static array $buildings = [];

    /** @var Collection<int, ImprovementType>[] */
    protected static array $improvements = [];

    /** @var Collection<int, ResourceType>[] */
    protected static array $resources = [];

    /** @var Collection<int, TechnologyType>[] */
    protected static array $requiredBys = [];

    /**
     * @return Collection<int, TechnologyType>
     */
    public static function all(): Collection
    {
        return static::instances(
            app_path('Technologies'),
            [TechnologyType::class, TechTree::class]
        );
    }

    /**
     * @return Collection<int, BuildingType>
     */
    public function buildings(): Collection
    {
        if (!isset(self::$buildings[static::class])) {
            self::$buildings[static::class] = collect();
            foreach (BuildingType::all() as $building) {
                if ($building->technology() === $this) {
                    self::$buildings[static::class][] = $building;
                }
            }
        }
        return self::$buildings[static::class];
    }

    /**
     * @return Collection<int, ImprovementType>
     */
    public function improvements(): Collection
    {
        if (!isset(self::$improvements[static::class])) {
            self::$improvements[static::class] = collect();
            foreach (ImprovementType::all() as $improvement) {
                if ($improvement->technology() === $this) {
                    self::$improvements[static::class][] = $improvement;
                }
            }
        }
        return self::$improvements[static::class];
    }

    /**
     * @return Collection<int, ResourceType>
     */
    public function resources(): Collection
    {
        if (!isset(self::$resources[static::class])) {
            self::$resources[static::class] = collect();
            foreach (ResourceType::all() as $resource) {
                if ($resource->technology() === $this) {
                    self::$resources[static::class][] = $resource;
                }
            }
        }
        return self::$resources[static::class];
    }


    /**
     * @return Collection<int, TechnologyType>
     */
    public function requiredBys(): Collection
    {
        if (!isset(self::$requiredBys[static::class])) {
            self::$requiredBys[static::class] = collect();
            foreach (TechnologyType::all() as $tech) {
                foreach ($tech->requires() as $requiredTech) {
                    if ($requiredTech === $this) {
                        self::$requiredBys[static::class][] = $tech;
                    }
                }
            }
        }
        return self::$requiredBys[static::class];
    }

    public function cost(): int
    {
        return round(pow($this->xy()->x, 1.5) * 5 + 10);
    }

    public function order(): int
    {
        return (int)(
            str_pad($this->xy()->x, 3, '0', STR_PAD_LEFT)
            . str_pad($this->xy()->y, 3, '0', STR_PAD_LEFT)
        );
    }

    abstract public function era(): TechnologyEra;

    public function icon(): string
    {
        return YieldType::Science->icon();
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    abstract public function requires(): Collection;

    abstract public function xy(): Coordinate;

    /**
     * @return Collection<int, YieldModifiersFor>
     */
    public function yieldModifiersFors(): Collection
    {
        return collect();
    }
}
