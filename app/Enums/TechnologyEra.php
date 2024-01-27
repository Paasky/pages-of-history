<?php

namespace App\Enums;

use App\GameConcept;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

enum TechnologyEra: string implements GameConcept
{
    use GameConceptEnum;

    case Neolithic = 'Neolithic';
    case Copper = 'Copper';
    case Bronze = 'Bronze';
    case Iron = 'Iron';
    case Classical = 'Classical';
    case Medieval = 'Medieval';
    case HighMedieval = 'HighMedieval';
    case Renaissance = 'Renaissance';
    case Enlightenment = 'Enlightenment';
    case Industrial = 'Industrial';
    case Gilded = 'Gilded';
    case Modern = 'Modern';
    case Atomic = 'Atomic';
    case Digital = 'Digital';
    case Information = 'Information';
    case Nano = 'Nano';

    public function name(): string
    {
        return \Str::title(str_replace('-', ' ', $this->slug()));
    }

    public function slug(): string
    {
        return \Str::kebab($this->name);
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function technologies(): Collection
    {
        return TechnologyType::all()->filter(fn(TechnologyType $type) => $type->era() === $this);
    }

    public function icon(): string
    {
        return YieldType::Science->icon();
    }

    /** @return Collection<int, GameConcept> */
    public function items(): Collection
    {
        return TechnologyType::all()->filter(
            fn(TechnologyType $type) => $type->era() === $this
        );
    }

    public function typeSlug(): string
    {
        return 'technology';
    }
}
