<?php

namespace App;

use App\Buildings\BuildingType;
use App\Improvements\ImprovementType;
use App\Resources\ResourceType;
use App\Technologies\TechnologyType;
use App\UnitArmor\UnitArmorType;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\UnitPlatformType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

abstract class AbstractType implements GameConcept, \Stringable
{
    /** @var Collection<int, AbstractType>[] */
    protected static array $all;

    /** @var Collection<int, AbstractType>[] */
    protected static array $allowsPerType = [];

    /** @var Collection<int, AbstractType>[] */
    protected static array $upgradesFromPerType = [];

    /** @var AbstractType[] */
    protected static array $singletons = [];

    public int $weight = 0;

    protected function __construct()
    {
    }

    /**
     * @return Collection<int, GameConcept>
     */
    public function allows(): Collection
    {
        if (!static::$allowsPerType) {
            foreach (
                [
                    BuildingType::all(),
                    ImprovementType::all(),
                    ResourceType::all(),
                    UnitPlatformType::all(),
                    UnitArmorType::all(),
                    UnitEquipmentType::all(),
                    TechnologyType::all(),
                ] as $gameConcepts
            ) {
                /** @var GameConcept $gameConcept */
                foreach ($gameConcepts as $gameConcept) {
                    foreach ($gameConcept->requires() as $require) {
                        static::$allowsPerType[get_class($require)][] = $gameConcept;
                    }
                }
            }
        }
        return collect(static::$allowsPerType[get_class($this)] ?? []);
    }

    abstract public function category(): GameConcept;

    public function dataForInit(): array
    {
        return ['class' => str_replace('\\', '\\\\', get_class($this)), 'id' => null];
    }

    public static function fromSlug(string $slug): static
    {
        foreach (static::all() as $type) {
            if ($type->slug() === $slug) {
                return $type;
            }
        }
        throw new \Exception("Could not find type with slug {$slug}");
    }

    public function hasDetails(): bool
    {
        return true;
    }

    /**
     * @return Collection<int, AbstractType>
     */
    protected static function instances(string $path, array $ignores): Collection
    {
        if (!isset(static::$all[$path])) {
            $classNames = ClassesInDirectory::get($path, $ignores);
            static::$all[$path] = collect();
            /** @var string|AbstractType $className */
            foreach ($classNames as $className) {
                static::$all[$path][] = $className::get();
            }
        }
        return static::$all[$path];
    }

    /**
     * @param ...$items
     * @return bool
     */
    public function is(...$items): bool
    {
        foreach ($items as $item) {
            if ($this === $item || $this->slug() === $item) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return Collection<int, GameConcept>
     */
    public function items(): Collection
    {
        return collect();
    }

    public static function get(): static
    {
        if (!isset(self::$singletons[static::class])) {
            self::$singletons[static::class] = new static();
        }
        return self::$singletons[static::class];
    }

    public function name(): string
    {
        return \Str::title(str_replace('-', ' ', $this->slug()));
    }

    public function shortName(): string
    {
        $words = explode('-', $this->slug());
        $words = array_map(
            function (string $word) use ($words) {
                if (count($words) === 1 && strlen($word) > 10) {
                    $word = substr($word, 0, 8) . '.';
                }
                if (count($words) > 1 && strlen($word) > 6) {
                    $word = substr($word, 0, 4) . '.';
                }
                return \Str::ucfirst($word);
            },
            $words
        );
        return implode(' ', $words);
    }

    public function slug(): string
    {
        return \Str::kebab(class_basename($this));
    }

    /** @return Collection<int, GameConcept> */
    public function requires(): Collection
    {
        return $this->technology()
            ? collect([$this->technology()])
            : collect();
    }

    public function technology(): ?TechnologyType
    {
        return null;
    }

    public function typeSlug(): string
    {
        return $this->category()->typeSlug();
    }

    public function typeName(): string
    {
        return \Str::title($this->typeSlug());
    }

    /** @return Collection<int, GameConcept> */
    public function upgradesFrom(): Collection
    {
        if (!static::$upgradesFromPerType) {
            foreach (
                [
                    BuildingType::all(),
                    ImprovementType::all(),
                    ResourceType::all(),
                    UnitPlatformType::all(),
                    UnitArmorType::all(),
                    UnitEquipmentType::all(),
                    TechnologyType::all(),
                ] as $gameConcepts
            ) {
                /** @var GameConcept $gameConcept */
                foreach ($gameConcepts as $gameConcept) {
                    if ($upgradesTo = $gameConcept->upgradesTo()) {
                        static::$upgradesFromPerType[get_class($upgradesTo)][] = $gameConcept;
                    }
                }
            }
        }
        return collect(static::$upgradesFromPerType[get_class($this)] ?? []);
    }

    public function upgradesTo(): ?GameConcept
    {
        return null;
    }

    /** @return Collection<int, YieldModifier|YieldModifiersFor> */
    public function yieldModifiers(): Collection
    {
        return collect();
    }

    public function __toString(): string
    {
        return $this->slug();
    }
}
