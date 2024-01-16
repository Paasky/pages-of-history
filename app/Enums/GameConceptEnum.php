<?php

namespace App\Enums;

use App\GameConcept;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

/**
 * @mixin GameConcept
 */
trait GameConceptEnum
{

    /**
     * @return Collection<int, GameConcept>
     */
    public function allows(): Collection
    {
        return collect();
    }

    public function dataForInit(): array
    {
        return ['class' => get_class($this), 'id' => $this->value];
    }

    public function category(): ?GameConcept
    {
        return null;
    }

    public function hasDetails(): bool
    {
        return false;
    }

    public function name(): string
    {
        return \Str::title(str_replace('-', ' ', $this->slug()));
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
        return $this->name;
    }

    public function typeName(): string
    {
        return \Str::title(str_replace('-', ' ', $this->typeSlug()));
    }

    /** @return Collection<int, YieldModifier|YieldModifiersFor> */
    public function yieldModifiers(): Collection
    {
        return collect();
    }
}
