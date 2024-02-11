<?php

namespace App;

use App\Technologies\TechnologyType;
use App\Yields\YieldModifier;
use App\Yields\YieldModifiersFor;
use Illuminate\Support\Collection;

interface GameConcept
{
    /** @return Collection<int, GameConcept> */
    public function allows(): Collection;

    public function category(): ?GameConcept;

    /**
     * #[ArrayShape(["class" => "string", "id" => "null", "string", "int"])
     * @return array
     */
    public function dataForInit(): array;

    public function description(): string;

    public function hasDetails(): bool;

    public function icon(): string;

    public function is(...$items): bool;

    /** @return Collection<int, GameConcept> */
    public function items(): Collection;

    public function name(): string;

    /** @return Collection<int, GameConcept> */
    public function requires(): Collection;

    public function shortName(): string;

    public function slug(): string;

    public function technology(): ?TechnologyType;

    public function typeName(): string;

    public function typeSlug(): string;

    /** @return Collection<int, GameConcept> */
    public function upgradesFrom(): Collection;

    public function upgradesTo(): ?GameConcept;

    /** @return Collection<int, YieldModifier|YieldModifiersFor> */
    public function yieldModifiers(): Collection;
}
