<?php

namespace App;

interface GameConcept
{
    public function category(): ?GameConcept;

    public function icon(): string;

    public function name(): string;

    public function shortName(): string;

    public function slug(): string;

    public function typeName(): string;

    public function typeSlug(): string;
}
