<?php

namespace App;

use App\Buildings\BuildingType;
use App\Improvements\ImprovementType;
use App\Resources\ResourceType;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

abstract class AbstractType
{
    /** @var Collection<int, AbstractType>[] */
    protected static array $all;

    /** @var AbstractType[] */
    protected static array $singletons = [];

    protected function __construct()
    {
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

    public static function get(): static
    {
        if (!isset(self::$singletons[static::class])) {
            self::$singletons[static::class] = new static();
        }
        return self::$singletons[static::class];
    }

    abstract public function icon(): string;

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

    /**
     * @return Collection<int, YieldModifiersFor>
     */
    public function yieldModifiersFors(): Collection
    {
        return collect();
    }

    /**
     * @return Collection<int, YieldModifier>
     */
    public function yieldModifiers(): Collection
    {
        return collect();
    }
}
