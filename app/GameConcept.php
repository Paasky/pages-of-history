<?php

namespace App;

use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

interface GameConcept
{
    /** @return Collection<int, GameConcept> */
    public function allows(): Collection;

    public function category(): ?GameConcept;

    public function hasDetails(): bool;

    public function icon(): string;

    /** @return Collection<int, GameConcept> */
    public function items(): Collection;

    public function name(): string;

    /** @return Collection<int, GameConcept> */
    public function requires(): Collection;

    public function shortName(): string;

    public function slug(): string;

    public function typeName(): string;

    public function typeSlug(): string;

    /**
     * #[ArrayShape(["class" => "string", "id" => "null", "string", "int"])
     * @return array
     */
    public function dataForInit(): array;

    /** @return Collection<int, YieldModifier|YieldModifiersFor> */
    public function yieldModifiers(): Collection;
}
