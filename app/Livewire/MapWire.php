<?php

namespace App\Livewire;

use App\Models\Map;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class MapWire extends Component
{
    public Map $map;

    public function render(): View
    {
        return view('livewire.map-wire');
    }

    public function mount(): void
    {
        $this->map = Map::firstOrFail();
    }
}
