<?php

namespace App;

use App\Buildings\BuildingType;
use App\Improvements\ImprovementType;
use App\Resources\ResourceType;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use Illuminate\Support\Collection;

abstract class AbstractType implements GameConcept
{
    /** @var Collection<int, AbstractType>[] */
    protected static array $all;

    /** @var AbstractType[] */
    protected static array $singletons = [];

    protected function __construct()
    {
    }

    /**
     * @return Collection<int, GameConcept>
     */
    public function allows(): Collection
    {
        $allows = collect();
        foreach (BuildingType::all() as $gameConcept) {
            foreach ($gameConcept->requires() as $require) {
                if ($require === $this) {
                    $allows->push($gameConcept);
                }
            }
        }
        foreach (ImprovementType::all() as $gameConcept) {
            foreach ($gameConcept->requires() as $require) {
                if ($require === $this) {
                    $allows->push($gameConcept);
                }
            }
        }
        foreach (ResourceType::all() as $gameConcept) {
            foreach ($gameConcept->requires() as $require) {
                if ($require === $this) {
                    $allows->push($gameConcept);
                }
            }
        }
        foreach (TechnologyType::all() as $gameConcept) {
            foreach ($gameConcept->requires() as $require) {
                if ($require === $this) {
                    $allows->push($gameConcept);
                }
            }
        }
        return $allows;
    }

    public function dataForInit(): array
    {
        return ['class' => get_class($this), 'id' => null];
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
        return match (true) {
            $this instanceof BuildingType => 'building',
            $this instanceof ImprovementType => 'improvement',
            $this instanceof ResourceType => 'resource',
            $this instanceof TechnologyType => 'technology',
            default => throw new \Exception(implode(' ', [
                'Register',
                get_class($this),
                'to',
                __CLASS__ . '->' . __FUNCTION__ . '()'
            ])),
        };
    }

    public function typeName(): string
    {
        return \Str::title($this->typeSlug());
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect();
    }
}
