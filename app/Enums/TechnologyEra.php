<?php

namespace App\Enums;

enum TechnologyEra: string
{
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
}
