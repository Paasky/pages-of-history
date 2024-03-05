<?php

namespace App\Enums;

use App\GameConcept;
use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

/**
 * @mixin GameConcept
 */
trait GameConceptEnum
{
    use PohEnum;

    /** @return Collection<int, GameConcept> */
    public function allows(): Collection
    {
        return collect();
    }

    public function cost(): ?int
    {
        return null;
    }

    public function dataForInit(): array
    {
        return ['class' => str_replace('\\', '\\\\', get_class($this)), 'id' => $this->value];
    }

    public function description(): string
    {
        return 'Description TBA';
    }

    public function category(): ?GameConcept
    {
        return null;
    }

    public function hasDetails(): bool
    {
        return false;
    }

    /**
     * @param ...$items
     * @return bool
     */
    public function is(...$items): bool
    {
        return in_array($this, $items, true);
    }

    public function slug(): string
    {
        return \Str::kebab($this->name);
    }

    /** @return Collection<int, GameConcept> */
    public function requires(): Collection
    {
        return collect();
    }

    public function shortName(): string
    {
        return $this->name();
    }

    public function name(): string
    {
        return \Str::title(str_replace('-', ' ', $this->slug()));
    }

    public function technology(): ?TechnologyType
    {
        return null;
    }

    public function typeName(): string
    {
        return \Str::title(str_replace('-', ' ', $this->typeSlug()));
    }

    /** @return Collection<int, GameConcept> */
    public function upgradesFrom(): Collection
    {
        return collect();
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
}
